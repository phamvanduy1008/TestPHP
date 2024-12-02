pipeline {
    agent any

    environment {
        MYSQL_ROOT_PASSWORD = credentials('mysql')
        MYSQL_CONTAINER_NAME = 'duyduy-mysql'
        MYSQL_VOLUME_NAME = 'duyduy-mysql-data'
        MYSQL_DATABASE = 'todoapp'
    }

    stages {
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

          stage('Deploy MySQL to DEV') {
            steps {
                script {
                    echo 'Deploying MySQL to DEV environment'
                    sh 'docker pull mysql:8.0'
                    sh 'docker network create dev || echo "Network already exists"'
                    sh "docker container stop ${MYSQL_CONTAINER_NAME} || echo '${MYSQL_CONTAINER_NAME} does not exist'"
                    sh 'docker container prune -f'
                    sh "docker volume rm ${MYSQL_VOLUME_NAME} || echo 'No volume to remove'"
                    sh """
                        docker run --name ${MYSQL_CONTAINER_NAME} --rm --network dev \
                        -v ${MYSQL_VOLUME_NAME}:/var/lib/mysql \
                        -e MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD} \
                        -e MYSQL_DATABASE=${MYSQL_DATABASE} \
                        -d mysql:8.0
                    """
                    sh 'sleep 20'
                    sh """
                        docker exec -i ${MYSQL_CONTAINER_NAME} mysql --user=root --password=${MYSQL_ROOT_PASSWORD} ${MYSQL_DATABASE} < script.sql
                    """
                }
            }
        }

         stage('Deploy PHP App to DEV') {
            steps {
                echo 'Deploying PHP app to DEV environment'

                sh 'docker image pull duyduy/my-php-app'

                sh 'docker container stop duyduy-php-app || echo "this container does not exist"'

                sh 'docker network create dev || echo "this network exists"'
                
                sh 'echo y | docker container prune'

                sh 'docker container run -d --rm --name duyduy-php-app -p 8080:80 --network dev duyduy/my-php-app'
            }
        }
    }

    post {
        always {
            cleanWs() 
        }
    }
}
