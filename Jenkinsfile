#!/usr/bin/env groovy

node {
    stage "Prepare environment"
        checkout scm
        def environment  = docker.build 'platforms-base'

        environment.inside {
            stage "Update Dependencies"
                sh "composer install"

            stage "Code Sniffer"
                catchError {
                    sh "./vendor/bin/phpcs --standard=ruleset.xml --report=checkstyle --report-file=phpcs.xml . || true"
                }
                sh 'cat phpcs.xml'
                step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', checkstyle: 'phpcs.xml', unstableTotalAll:'0'])

            stage "Copy-Paste Detection"
                sh "./vendor/bin/phing phpcpd"

            stage "Mess Detection"
                catchError {
                    sh "./vendor/bin/phpmd . --exclude vendor,var,build,tests xml codesize,naming,unusedcode,controversial,design --reportfile=phpmd.xml"
                }
                sh 'cat phpmd.xml'

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