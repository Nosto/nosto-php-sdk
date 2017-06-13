#!/usr/bin/env groovy

node {
    stage "Prepare environment"
        checkout scm
        def environment  = docker.build 'platforms-base'

        environment.inside {
            stages {
                stage('Build') {
                    steps {
                        sh 'make'
                    }
                }
                stage('Test'){
                    steps {
                        sh 'make check'
                        junit 'reports/**/*.xml'
                    }
                }
                stage('Deploy') {
                    steps {
                        sh 'make publish'
                    }
                }
            }
        }

    stage "Cleanup"
        deleteDir()
}