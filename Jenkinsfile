node {
    stage('Cleanup') {
        deleteDir()
    }

    stage('Checkout') {
        checkout scm
    }

    stage('Deps') {
        echo '-- Installing dependencies -- '
        sh 'composer install'
        echo '-- Dependencies installed -- '
    }

    stage('Test') {
        // Prepare the testing environment
        sh 'cp .env.testing .env'
        sh 'php artisan key:generate'

        echo '-- Testing the application -- '
        sh 'vendor/bin/phpunit --log-junit test-results.xml'
        junit allowEmptyResults: true, testResults: 'test-results.xml'
    }

    stage('Deploy') {
        echo '-- Deploying the application --'

        def remote = "${USERNAME}@${SERVER_IP} -p ${SSH_PORT}"
        sshagent(
            credentials: ['47f7eb21-7cb6-45a1-a348-8d8e10817dc0'],
            ignoreMissing: true
        ) {
            sh "ssh ${remote} && cd ${FOLDER} && pwd && git pull origin master"
        }
    }

    stage('Notify') {
        slackSend "Build done: ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)"
    }
}
