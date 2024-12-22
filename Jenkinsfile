pipeline {

    agent any

    environment {
        DOCKERHUB_CREDENTIALS = credentials('dockerhub') 
        IMAGE_NAME = 'binhnguyen317/website'
    }

    stages {

        stage('Checkout Code') {
            steps {
                echo 'Lấy mã nguồn từ repository Git'
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                echo 'Đóng gói ứng dụng HTML/CSS vào Docker Image'
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Push Docker Image to DockerHub') {
            steps {
                echo 'Đẩy Docker Image lên DockerHub'
                withDockerRegistry(credentialsId: 'dockerhub', url: 'https://index.docker.io/v1/') {
                    sh 'docker push $IMAGE_NAME'
                }
            }
        }

        stage('Deploy to DEV Environment') {
            steps {
                echo 'Triển khai ứng dụng trên DEV'
                sh 'docker container stop html-app || echo "Container không tồn tại"'
                sh 'docker container rm html-app || echo "Không có container cần xóa"'
                sh 'docker run -d --rm --name html-app -p 8008:80 $IMAGE_NAME'
            }
        }
    }

    post {
        always {
            echo 'Dọn dẹp workspace sau khi hoàn tất'
            cleanWs()
        }
    }
}
