pipeline {
    agent {
        docker {
                  image 'docker:latest'
                  args  '-v /var/run/docker.sock:/var/run/docker.sock'
        }
    }
    options {
        buildDiscarder(logRotator(numToKeepStr: '5'))
    }

    stages {
        stage('Build & Tag The Image') {
            steps {
                echo "Build & Tag the Image"
                sh "printenv"
                sh "docker image build -f Dockerfile.debian.php -t gworkx/img:php-${TAG_NAME} . "
                sh "docker image build -f Dockerfile.debian.php -t gworkx/img:php-latest . "
            }
        }

        stage('Publish') {
              steps {
                    echo "Publish The Image"
                    withDockerRegistry([ credentialsId: "gworkx-dockerhub", url: "" ]) {
                        sh "docker push gworkx/img:php-${TAG_NAME}"
                        sh "docker push gworkx/img:php-latest"
                    }
              }
        }
    }
}
