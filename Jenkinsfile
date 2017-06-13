#!/usr/bin/env groovy

node {
    stage "Prepare environment"
        checkout scm
        def environment  = docker.build 'platforms-base'

        environment.inside {
            stage "Update Dependencies"
                sh "composer install"

            stage "PHPCS"
                sh "./vendor/bin/phing phpcs"

            stage "PHPCBF"
                sh "./vendor/bin/phing phpcbf"

            stage "PHPCPD"
                sh "./vendor/bin/phing phpcpd"

            stage "PHPMD"
                sh "./vendor/bin/phing phpmd"
        }

    stage "Cleanup"
        deleteDir()
}