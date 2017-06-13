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
                step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', pattern: 'phpcs.xml', unstableTotalAll:'0'])

            stage "Copy-Paste Detection"
                sh "./vendor/bin/phing phpcpd"

            stage "Mess Detection"
                catchError {
                    sh "./vendor/bin/phpmd . xml codesize,naming,unusedcode,controversial,design --exclude vendor,var,build,tests --reportfile phpmd.xml"
                }
                sh 'cat phpmd.xml'
                //step([$class: 'PmdPublisher', pattern: 'phpmd.xml', unstableTotalAll:'0'])

            stage "Phan Analysis"
                sh "./vendor/bin/phing phan"

            stage "Unit Tests"
                catchError {
                    sh "./vendor/bin/codecept run --xml"
                }
                sh "tree tests"
                step([$class: 'JUnitResultArchiver', testResults: 'tests/_output/report.xml'])
        }

    stage "Cleanup"
        deleteDir()
}