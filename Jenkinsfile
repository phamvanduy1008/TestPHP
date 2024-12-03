pipeline {
    agent any

    environment {
        MYSQL_ROOT_LOGIN = credentials('mysql')
        MYSQL_ROOT_LOGIN_PSW = 123456
    }

    stages {

        stage('Pull Latest Code from Git') {
            steps {
                echo 'Pulling latest code from Git repository'
                git branch: 'main', url: 'https://github.com/phamvanduy1008/TestPHP.git'
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh 'php -v'
                sh 'composer -v'
                sh 'composer install'  
            }
        }

        stage('Packaging/Pushing Image') {
            steps {
                withDockerRegistry(credentialsId: 'dockerhub', url: 'https://index.docker.io/v1/') {
                    sh 'docker build -t phamvanduy108/my-php-app .'
                    sh 'docker push phamvanduy108/my-php-app'
                }
            }
        }
        
        stage('Deploy PHP App to DEV') {
            steps {
                echo 'Deploying PHP app to DEV environment'

                sh 'docker image pull phamvanduy108/my-php-app'

                sh 'docker container stop duyduy-php-app || echo "this container does not exist"'

                sh 'docker network create dev || echo "this network exists"'
                
                sh 'echo y | docker container prune '

                sh 'docker container run -d --rm --name duyduy-php-app -p 8000:80 --network dev duyduy/my-php-app'
            }
        }
    }


    post {
        always {
            cleanWs() 
        }
    }
}
