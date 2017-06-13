#!/usr/bin/env groovy

node {
  stage ('Checkout') {
    checkout scm
  }

  stage ('Build') {
    docker.image('composer/composer').inside() {
        sh 'echo test'
        sh 'composer install'
    }
  }

  stage ('Test') {
      sh 'composer install'
      step([$class: 'JUnitResultArchiver', testResults: 'test/reports/sdk-report.xml'])
  }
}