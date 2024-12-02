pipeline {
    agent any

    environment {
        MYSQL_ROOT_LOGIN = credentials('mysql')
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
                    sh 'docker build -t duyduy/my-php-app .'
                    sh 'docker push duyduy/my-php-app'
                }
            }
        }
stage('Deploy MySQL to DEV') {
    steps {
        script {
            echo 'Deploying MySQL to DEV environment'

            sh 'docker image pull mysql:8.0'
            sh 'docker network inspect dev >/dev/null 2>&1 || docker network create dev'
            sh 'docker container stop duyduy-mysql || true'
            sh 'docker container prune -f'
            sh 'docker volume rm duyduy-mysql-data || true'

            sh """
            docker run --name duyduy-mysql --rm --network dev \
                -v duyduy-mysql-data:/var/lib/mysql \
                -e MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_LOGIN_PSW} \
                -e MYSQL_DATABASE=db_example \
                -d mysql:8.0
            """

            sh 'sleep 20'

            sh """
            docker exec -i $(docker ps -q --filter "name=duyduy-mysql") mysql \
                --user=root --password=${MYSQL_ROOT_LOGIN_PSW} < script.sql
            """
        }
    }
}

stage('Deploy PHP App to DEV') {
    steps {
        script {
            echo 'Deploying PHP app to DEV environment'

            sh 'docker image pull duyduy/my-php-app'
            sh 'docker container stop duyduy-php-app || true'
            sh 'docker network inspect dev >/dev/null 2>&1 || docker network create dev'
            sh 'docker container prune -f'

            sh """
            docker container run -d --rm --name duyduy-php-app \
                -p 8080:80 --network dev duyduy/my-php-app
            """
        }
    }
}


    post {
        always {
            cleanWs() 
        }
    }
}
