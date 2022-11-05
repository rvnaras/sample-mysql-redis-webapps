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
              //echo $DOCKERHUB_CREDENTIALS_PSW | docker login -u $DOCKERHUB_CREDENTIALS_USR --password-stdin
              //docker build -f ./webapp/Dockerfile.webapp -t ravennaras/wlb:webapp-$GIT_COMMIT_SHORT . --network host 
              //docker build -f ./redis/Dockerfile.redis -t ravennaras/wlb:redis-$GIT_COMMIT_SHORT . --network host
            '''
      }
    }
    stage('TEST') {
      steps {
            sh '''
              echo 'check deployment image vulnerabilities'
              // docker run --network host aquasec/trivy image ravennaras/wlb:webapp --security-checks vuln
              // docker run --network host aquasec/trivy image ravennaras/wlb:redis --security-checks vuln
              // skipped security test
              //docker push ravennaras/wlb:webapp-$GIT_COMMIT_SHORT
              //docker push ravennaras/wlb:redis-$GIT_COMMIT_SHORT
            '''
      }
    }
    stage('DEPLOY') {
      steps {
          sh '''
             echo 'deploy to cluster'
             // aws configure set default.region us-east-1 && aws configure set aws_access_key_id $AWS_ACCESS_KEY_ID && aws configure set aws_secret_access_key $AWS_SECRET_ACCESS_KEY
             // aws eks update-kubeconfig --name=cilsy-eks
             // echo login successful
             // argocd login $ARGOCD_URL --username $ARGOCD_CREDENTIALS_USR --password $ARGOCD_CREDENTIALS_PSW --insecure
	     // echo argocd login successful
	     // argocd app get sample-mysq-redis-webapps
             // argocd app sync sample-mysq-redis-webapps
           '''
      }
    }
  }
}
