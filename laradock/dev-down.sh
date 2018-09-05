#!/bin/sh
export APP_NAME=$1
export HOST_HTTP_PORT=$2
export HOST_HTTPS_PORT=$3
export PHP_FPM_PORT=$4
export WORKSPACE_SSH_PORT=$5
echo "${APP_NAME} going down"
export CONTAINER_NAME_PREFIX=${APP_NAME}
export COMPOSE_PROJECT_NAME="Dribly"
export APPLICATION=../

echo ${APP_NAME}
docker-compose --project-name=${APP_NAME} down --rmi all
echo "All done downing ${APP_NAME}. Hope it worked"
