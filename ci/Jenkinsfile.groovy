pipeline {
    agent any
    environment {
        IMAGE_TO_DEPLOY = ''
    }

    stages {
        stage('SetUp') {
            agent {
                docker {
                    image 'python:alpine'
                    args '-v $HOME/.ssh.jenkins:/root/.ssh'
                }
            }
            steps {
                echo 'SetUp The Build Env For Python 3 Alpine >>'
                sh"""
                    apk update && apk upgrade && apk add --no-cache build-base alpine-sdk git bash \
                    openssh-client openssl-dev python-dev libffi-dev libxml2-dev rsync
                    printenv
                """
                script {
                    echo 'Select Repo To Build An Image >>'
                    def repoURI
                    def selectRepo = input(id: 'selectRepo', message: 'Select Repo To Build',
                        parameters: [
                            [$class: 'ChoiceParameterDefinition', choices:['php','kitabu', 'wines', 'kisoda'], name: 'optsRepo']
                        ])
                    IMAGE_TO_DEPLOY = "${selectRepo}"
                    println "Building & Deploying: ${IMAGE_TO_DEPLOY} "

                    // we do not want to do anything if php - we are in its repo
                    if (selectRepo != 'php') {
                        if (selectRepo == 'kitabu') {
                            repoURI = 'git@bitbucket.org:irinroy/' + "${selectRepo}" + '.git'
                        } else {
                            repoURI = 'git@bitbucket.org:gworkx/' + "${selectRepo}" + '.git'
                        }
                        if (fileExists('./checkout-code')) {
                            sh"""
                                rm -rf ./checkout-code
                            """
                        }
                        sh"""
                            git version
                            echo "${selectRepo}"
                            git clone ${repoURI} checkout-code
                            ls -al ./checkout-code
                        """
                    }
                }
            }
        } // end stage SetUp

        stage('Build & Tag The Image') {
            agent {
                docker {
                      image 'docker:latest'
                      args  '-v /var/run/docker.sock:/var/run/docker.sock'
                }
            }
            steps {
                script {
                    if (IMAGE_TO_DEPLOY == 'php') {
                        sh "docker image build -f Dockerfile.debian.php -t gworkx/img:php-${TAG_NAME} . "
                        sh "docker image build -f Dockerfile.debian.php -t gworkx/img:php-latest . "
                    } else {
                        echo 'Build The Image >>'
                        sh "docker image build --no-cache -t gworkx/img:${IMAGE_TO_DEPLOY}-latest -f Dockerfile.cake ."
                    }
                }
            }
        } // end stage Build & Tag The Image

        stage('Publish') {
            agent {
                docker {
                      image 'docker:latest'
                      args  '-v /var/run/docker.sock:/var/run/docker.sock'
                }
            }
            steps {
                echo "Publish The Image for ${IMAGE_TO_DEPLOY}>>"
                script {
                    if (IMAGE_TO_DEPLOY == 'php') {
                        withDockerRegistry([ credentialsId: "gworkx-dockerhub", url: "" ]) {
                            sh "docker push gworkx/img:php-${TAG_NAME}"
                        }
                    }

                    withDockerRegistry([ credentialsId: "gworkx-dockerhub", url: "" ]) {
                        sh "docker push gworkx/img:${IMAGE_TO_DEPLOY}-latest"
                    }
                }
            }
        } // end stage Publish
    } //end stages
    post {
        always {
            echo 'CLEANING UP >>'
            deleteDir()
        }
    }
}
