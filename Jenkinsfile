#!/usr/bin/env groovy

node {
  stage "Prepare environment"
  checkout scm
  def environment  = docker.build 'platforms-base'

  environment.inside {
    stage "Update Dependencies"
    sh "composer install"

    stage "Code Sniffer" {
      catchError {
        sh "./vendor/bin/phpcbf --standard=ruleset.xml . || true"
        sh "./vendor/bin/phpcs --standard=ruleset.xml --report=checkstyle --report-file=chkphpcs.xml . || true"
      }
      archiveArtifacts "chkphpcs.xml"
    }

    stage "Copy-Paste Detection" {
      catchError {
        sh "./vendor/bin/phpcpd --exclude=vendor --exclude=build --log-pmd=phdpcpd.xml src || true"
      }
      archiveArtifacts "phdpcpd.xml"
    }

    stage "Mess Detection" {
      catchError {
        sh "./vendor/bin/phpmd . xml codesize,naming,unusedcode,controversial,design --exclude vendor,var,build,tests --reportfile pmdphpmd.xml || true"
      }
      archiveArtifacts "pmdphpmd.xml"
    }

    stage "Phan Analysis" {
      catchError {
        sh "./vendor/bin/phan --config-file=phan.php --output-mode=checkstyle --output=chkphan.xml || true"
      }
      archiveArtifacts "chkphan.xml"
    }

    stage "Unit Tests" {
      catchError {
        sh "./vendor/bin/codecept run --xml"
      }
      archiveArtifacts "tests/_output/report.xml"
      junit 'tests/_output/report.xml'
    }
  }

  post {
    always {
      checkstyle pattern: 'chk*.xml', unstableTotalAll:'0'
      pmd pattern: 'pmd*.xml', unstableTotalAll:'0'
      deleteDir()
    }
  }
}
