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
                    sh "./vendor/bin/phpcbf --standard=ruleset.xml . || true"
                    sh "./vendor/bin/phpcs --standard=ruleset.xml --report=checkstyle --report-file=phpcs.xml . || true"
                }
                step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', pattern: 'phpcs.xml', unstableTotalAll:'0'])

            stage "Copy-Paste Detection"
                sh "./vendor/bin/phpcpd --exclude=vendor --exclude=build --log-pmd=phpcpd.xml src || true"

            stage "Mess Detection"
                catchError {
                    sh "./vendor/bin/phpmd . xml codesize,naming,unusedcode,controversial,design --exclude vendor,var,build,tests --reportfile phpmd.xml || true"
                }
                //step([$class: 'PmdPublisher', pattern: 'phpmd.xml', unstableTotalAll:'0'])

            stage "Phan Analysis"
                catchError {
                    sh "./vendor/bin/phan --config-file=phan.php --output-mode=checkstyle --output=phan.xml || true"
                }
                step([$class: 'hudson.plugins.checkstyle.CheckStylePublisher', pattern: 'phan.xml', unstableTotalAll:'0'])

            stage "Unit Tests"
                catchError {
                    sh "./vendor/bin/codecept run --xml"
                }
                step([$class: 'JUnitResultArchiver', testResults: 'tests/_output/report.xml'])
        }

    stage "Cleanup"
        deleteDir()
}
