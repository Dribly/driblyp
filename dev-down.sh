#!/bin/sh

export APP_NAME=dribly-web
export NGINX_HOSTNAME=dribly
echo "${APP_NAME} going down"
export CONTAINER_NAME_PREFIX="dribly-dev"
export COMPOSE_PROJECT_NAME="Dribly-Dev"

echo ${APP_NAME}
docker-compose -f docker-compose.yml --project-name="${COMPOSE_PROJECT_NAME}" down --rmi all
if [ $? -eq 0 ]
 then
    echo "All done. downing ${APP_NAME}  Hope it worked"
else
    echo "might have been a problem loading ${APP_NAME}"
fi
