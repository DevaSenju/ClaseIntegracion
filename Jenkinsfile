pipeline {
    agent any

    stages {

        stage('Clonar repositorio') {
            steps {
                echo 'Repositorio obtenido desde GitHub'
            }
        }

        stage('Validacion') {
            steps {
                echo 'Pipeline ejecutado correctamente'
            }
        }

        stage('Construir imagen Docker') {
            steps {
                echo 'En un entorno productivo aqui se ejecutaria:'
                echo 'docker build -t claseintegracion .'
            }
        }

        stage('Finalizacion') {
            steps {
                echo 'Proceso completado correctamente'
            }
        }
    }

    post {
        success {
            echo 'Pipeline finalizado con exito'
        }

        failure {
            echo 'Pipeline finalizado con errores'
        }
    }
}