#!/usr/bin/env groovy

node {
    stage('Prepare environment') {
        checkout scm
        def environment  = docker.build 'platforms-base'

        environment.inside {
            stage('Update Dependencies') {
                sh "composer install"
            }

            stage('Code Sniffer') {
                sh "./vendor/bin/phing phpcs"
            }

            stage('Copy-Paste Detection') {
                sh "./vendor/bin/phing phpcpd"
            }

            stage('Mess Detection') {
                sh "./vendor/bin/phing phpmd"
            }

            stage('Phan Analysis') {
                sh "./vendor/bin/phing phan"
            }
        }
    }

    stage('Cleanup') {
        deleteDir()
    }
}