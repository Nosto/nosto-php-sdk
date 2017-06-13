#!/usr/bin/env groovy

node {
  stage ('Checkout') {
    checkout scm
  }

  stage ('Build') {
    docker.image('composer/composer').inside() {
        sh 'echo test'
        sh 'apt-get update'
        sh 'apt-get install -y php7.0 zip unzip php7.0-zip php7.0-curl'
        sh 'docker-php-ext-install pcntl'
        sh 'docker-php-ext-install ast'
        sh 'composer install'
    }
  }

  stage ('Test') {
      sh 'composer install'
      step([$class: 'JUnitResultArchiver', testResults: 'test/reports/sdk-report.xml'])
  }
}