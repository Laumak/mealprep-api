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

        try {

        } catch($e) {
            slackSend "Build failed: ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>). Reason: ${$e}"
        }

        echo '-- Testing the application -- '
        sh 'vendor/bin/phpunit --log-junit test-results.xml'
        junit allowEmptyResults: true, testResults: 'test-results.xml'
    }

    stage('Deploy') {
        echo '-- Deploying the application --'

        def remote = "${USERNAME}@${SERVER_IP} -p ${SSH_PORT}"
        sshagent(['jenkins-ssh-key']) {
            sh "ssh ${remote} git -C ${FOLDER} pull"
        }
    }

    stage('Notify') {
        slackSend "Build done: ${env.JOB_NAME} ${env.BUILD_NUMBER} (<${env.BUILD_URL}|Open>)"
    }
}
