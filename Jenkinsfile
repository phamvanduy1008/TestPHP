pipeline {
    agent any

    environment {
        MYSQL_ROOT_LOGIN = credentials('mysql')
    }

    stages {

        stage('Pull Latest Code from Git') {
            steps {
                echo 'Pulling latest code from Git repository'
                sh 'git clone https://github.com/phamvanduy1008/TestPHP.git . || git pull'
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

                sh 'docker container run -d --rm --name duyduy-php-app -p 8000:80 --network dev -v $(pwd):/var/www/html phamvanduy108/my-php-app'
            }
        }
    }

    //  stage('Deploy MySQL to DEV') {
    //         steps {
    //             echo 'Deploying MySQL to DEV environment'
    //             sh 'docker image pull mysql:8.0'
                
    //             sh 'docker network create dev || echo "this network exists"'
                
    //             sh 'docker container stop duyduy-mysql || echo "this container does not exist" '
                
    //             sh 'echo y | docker container prune '
                
    //             sh 'docker volume rm duyduy-mysql-data || echo "no volume"'

    //             sh "docker run --name duyduy-mysql --rm --network dev -v duyduy-mysql-data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_LOGIN_PSW} -e MYSQL_DATABASE=db_example -d mysql:8.0"
    //             sh 'sleep 20'

    //             sh "docker exec -i duyduy-mysql mysql --user=root --password=${MYSQL_ROOT_LOGIN_PSW} < script.sql"
    //         }
    //     }

    post {
        always {
            cleanWs() 
        }
    }
}
