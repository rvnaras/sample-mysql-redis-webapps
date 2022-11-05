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
              docker build -f ./redis/Dockerfile.redis -t ravennaras/wlb:redis-latest . --network host
              docker build -f ./apps/Dockerfile.apps -t ravennaras/wlb:webapp-latest . --network host
            '''
      }
    }
    stage('TEST') {
      steps {
            sh '''
              echo 'check deployment image for vulnerabilities and push them to hub'
              docker push ravennaras/wlb:redis-latest
              docker push ravennaras/wlb:webapp-latest
            '''
      }
    }
    stage('DEPLOY') {
      steps {
          sh '''
             echo 'deploy to cluster'
             argocd login $ARGOCD_URL --username $ARGOCD_CREDENTIALS_USR --password $ARGOCD_CREDENTIALS_PSW --insecure
	           echo argocd login successful
             argocd app get musyaffadli.com
             argocd app sync musyaffadli.com
           '''
      }
    }
  }
}
