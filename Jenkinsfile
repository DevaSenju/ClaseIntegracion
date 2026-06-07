pipeline {
    agent any

    stages {

        stage('Clonar repositorio') {
            steps {
                echo 'Repositorio obtenido desde GitHub'
            }
        }

        stage('Construir imagen Docker') {
            steps {
                bat 'docker build -t claseintegracion .'
            }
        }

        stage('Verificar construcción') {
            steps {
                echo 'Imagen Docker construida correctamente'
            }
        }
    }
}