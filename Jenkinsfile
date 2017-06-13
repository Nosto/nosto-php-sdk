#!/usr/bin/env groovy

node {
  stage 'Checkout'
  checkout scm

  stage 'Build'
  sh 'echo "test"'

  stage 'Test'
  sh 'composer install'
}
