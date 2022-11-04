pipeline {
  agent {
    kubernetes {
      yaml '''
        apiVersion: v1
        kind: Pod
        spec:
          containers:
          - name: docker
            image: docker:dind
            securityContext:
              allowPrivilegeEscalation: true
            command:
            - cat
            tty: true
            volumeMounts:
            - name: dockersock
              mountPath: 'var/run/docker.sock'
          - name: pods
            image: ravennaras/template:eksctl-argo-v1
            securityContext:
              allowPrivilegeEscalation: true
            tty: true
          volumes:
          - name: dockersock
            hostPath:
              path: /var/run/docker.sock
        '''
    }
  }
  environment{
    DOCKERHUB_CREDENTIALS=credentials('docker')
    ARGOCD_CREDENTIALS=credentials('argocd')
    ARGOCD_URL=credentials('argocd-url')
  }
  stages {
    stage('BUILD') {
      steps {
        container('docker') {
            sh '''
              echo 'building deployment image'
              echo $DOCKERHUB_CREDENTIALS_PSW | docker login -u $DOCKERHUB_CREDENTIALS_USR --password-stdin
              docker build -f ./webapp/Dockerfile.webapp -t ravennaras/wlb:webapp . --network host 
              docker build -f ./redis/Dockerfile.redis -t ravennaras/wlb:redis . --network host
            '''
        }
      }
    }
    stage('TEST') {
      steps {
        container('docker') {
            sh '''
              echo 'check deployment image vulnerabilities'
              // docker run --network host aquasec/trivy image ravennaras/wlb:webapp --security-checks vuln
              // docker run --network host aquasec/trivy image ravennaras/wlb:redis --security-checks vuln
              // skipped security test
              docker push ravennaras/wlb:webapp
              docker push ravennaras/wlb:redis
            '''
        }
      }
    }
    stage('DEPLOY') {
      steps {
        container('pods'){
          //withAWS(credentials: 'aws'){
            sh '''
              echo 'deploy to cluster'
              // aws configure set default.region us-east-1 && aws configure set aws_access_key_id $AWS_ACCESS_KEY_ID && aws configure set aws_secret_access_key $AWS_SECRET_ACCESS_KEY
              // aws eks update-kubeconfig --name=cilsy-eks
              // echo login successful
              argocd login $ARGOCD_URL --username $ARGOCD_CREDENTIALS_USR --password $ARGOCD_CREDENTIALS_PSW --insecure
	      echo argocd login successful
	      argocd app get sample-mysq-redis-webapps
              argocd app sync sample-mysq-redis-webapps
            '''
          //}
        }
      }
    }
  }
}

