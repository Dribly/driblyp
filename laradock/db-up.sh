#!/bin/sh

export APP_NAME=$1
export HOST_HTTP_PORT=$2
export HOST_HTTPS_PORT=$3
export PHP_FPM_PORT=$4
export WORKSPACE_SSH_PORT=$5
echo "${APP_NAME} going up"
export CONTAINER_NAME_PREFIX=${APP_NAME}
export COMPOSE_PROJECT_NAME="Dribly"
export APPLICATION=./

export PHP_INTERPRETER=php-fpm
APPLICATION=../
echo "Building $CONTAINER_NAME_PREFIX, HTTP $HOST_HTTP_PORT -> PHP $PHP_FPM_PORT"

docker-compose --project-name=${APP_NAME} up -d phpmyadmin php-fpm mariadb
echo "All done. Hope it worked"
