#!/usr/bin/env groovy

node {
    stage "Prepare environment"
        checkout scm
        def environment  = docker.build 'platforms-base'

        environment.inside {
            stage "Update Dependencies"
                sh "composer install"

            stage "Code Sniffer"
                sh "./vendor/bin/phpcs --standard=ruleset.xml --report=checkstyle --report-file=phpcs.xml ."

            stage "Copy-Paste Detection"
                sh "./vendor/bin/phing phpcpd"

            stage "Mess Detection"
                sh "./vendor/bin/phing phpmd"

            stage "Phan Analysis"
                sh "./vendor/bin/phing phan"

            stage "Unit Tests"
                sh "./vendor/bin/codecept run --xml"
                sh "ls -lah"

            stage 'Report'
                step([$class: 'JUnitResultArchiver', testResults: 'tests/_output/report.xml'])
        }

    stage "Cleanup"
        deleteDir()
}