#!/bin/sh

echo "${APP_NAME} going up"
export CONTAINER_NAME_PREFIX=driblyp
export COMPOSE_PROJECT_NAME="Dribly"
export APPLICATION=../
DATE=`date '+%Y%m%d%H%M%S'`
echo $DATE
#exit
export BUILDID="build-${DATE}"

echo "Building ${CONTAINER_NAME_PREFIX}"
if [ "$1" == "" ] || [ "$1" == "all" ]; then
   SERVICE=""
else
   SERVICE="$1"
fi

echo "docker-compose -f build/docker-compose-prod-core.yml --project-name=\"${COMPOSE_PROJECT_NAME}\" build core"
docker-compose -f build/docker-compose-prod-core.yml --project-name="${COMPOSE_PROJECT_NAME}" build core
docker tag "powellblyth/dribly-core" ${BUILDID}
echo "docker-compose -f build/docker-compose-prod.yml --project-name=\"${COMPOSE_PROJECT_NAME}\" build"
docker-compose -f build/docker-compose-prod.yml --project-name="${COMPOSE_PROJECT_NAME}" build $SERVICE

#docker build -t powellblyth/dribly:latest -f ./docker/php-fpm/php-Dockerfile-prod .
#docker build -t powellblyth/dribly-nginx:latest -f ./docker/nginx/Dockerfile .
#docker build -t powellblyth/dribly-workspace:latest -f ./docker/workspace/Dockerfile-71-prod ./docker/workspace
#docker build -t powellblyth/dribly-mqtt-listener:latest -f ./docker/php-mqtt-listener/php-Dockerfile-prod ./docker/php-mqtt-listener
##docker-compose -f docker-compose-prod.yml -t powellblyth/dribly --project-name="${COMPOSE_PROJECT_NAME}" build
#
#exit

# don't proceed ig there was an error
if [ $? -lt 1 ]; then
    docker login
    #
    if [ $? -lt 1 ]; then

        if [ "$VERB" == "" ] || [ "$VERB" == "php-fpm" ]; then
        echo "push dribly"
            docker push powellblyth/dribly
        fi

        docker push powellblyth/dribly-core

        if [ "$VERB" == "" ] || [ "$VERB" == "nginx" ]; then
            echo "push dribly nginx"
            docker push powellblyth/dribly-nginx
        fi

        if [ "$VERB" == "" ] || [ "$VERB" == "web-workspace" ]; then
            echo "push workspace"
            docker push powellblyth/dribly-workspace
        fi

        if [ "$VERB" == "" ] || [ "$VERB" == "php-mqtt-listener" ]; then
            echo "push mqtt listener"
            docker push powellblyth/dribly-mqtt-listener
         fi

        echo "building builds/package-${BUILDID}.tgz"
        if [ ! -d ./builds ]; then
            mkdir builds
        fi
        rm builds/*

        echo ${BUILDID} > dribly-deploy/buildid.txt

        tar zcf "builds/package-${BUILDID}.tgz" ./dribly-deploy/*
    fi
fi

#sftp -i "~/TobyMay2018.pem" ec2-user@ec2-34-253-183-211.eu-west-1.compute.amazonaws.com