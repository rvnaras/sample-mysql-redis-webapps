pipeline {
  agent any
  environment{
    GIT_COMMIT_SHORT = sh(returnStdout: true, script: '''echo $GIT_COMMIT | head -c 7''')
    PROJECT_ID = 'iconic-apricot-367505'
    CLUSTER_NAME = 'gke-assessment'
    LOCATION = 'asia-east1'
    CREDENTIALS_ID = 'sample-app'
    DOCKERHUB_CREDENTIALS=credentials('dockerID')
    ARGOCD_CREDENTIALS=credentials('argocd')
    ARGOCD_URL=credentials('argocd-url')
  }
  stages {
    stage('BUILD') {
      steps {
            sh '''
              echo 'building deployment image'
              docker build -f ./redis/Dockerfile.redis -t ravennaras/wlb:redis-$GIT_COMMIT_SHORT . --network host
              docker build -f ./apps/Dockerfile.apps -t ravennaras/wlb:webapp-$GIT_COMMIT_SHORT . --network host
            '''
      }
    }
    stage('TEST') {
      steps {
            sh '''
              echo 'check deployment image for vulnerabilities and push them to hub'
              docker push ravennaras/wlb:redis-$GIT_COMMIT_SHORT
              docker push ravennaras/wlb:webapp-$GIT_COMMIT_SHORT
            '''
      }
    }
    stage('DEPLOY') {
      steps {
          sh '''
             echo 'deploy to cluster'
           '''
      }
    }
  }
}
