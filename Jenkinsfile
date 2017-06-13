#!/usr/bin/env groovy

node {
  stage ('Checkout') {
    checkout scm
  }

  stage ('Build') {
    docker.image('php:7.0-cli').inside() {
        sh 'echo test'
    }
  }

  stage ('Test') {
      sh 'composer install'
      step([$class: 'JUnitResultArchiver', testResults: 'test/reports/sdk-report.xml'])
  }
}