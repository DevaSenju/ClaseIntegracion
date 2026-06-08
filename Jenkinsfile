pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Construir imagen Docker') {
            steps {
                sh 'docker build -t claseintegracion .'
            }
        }

        stage('Validar imagen') {
            steps {
                sh 'docker images | grep claseintegracion'
            }
        }

        stage('Eliminar contenedor anterior') {
            steps {
                sh 'docker rm -f claseintegracion-test || true'
            }
        }

        stage('Crear contenedor de prueba') {
            steps {
                sh 'docker run -d --name claseintegracion-test -p 8082:80 claseintegracion'
            }
        }

        stage('Validar contenedor') {
            steps {
                sh 'docker ps | grep claseintegracion-test'
            }
        }
    }

    post {
        success {
            echo 'Imagen Docker construida y contenedor creado correctamente'
        }

        failure {
            echo 'Error durante la ejecucion del pipeline'
        }
    }
}