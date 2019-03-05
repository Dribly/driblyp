#!/bin/sh


export APPLICATION=../
export CONTAINER_NAME_PREFIX="dribly-prod"
export COMPOSE_PROJECT_NAME="Dribly-Prod"

export HOST_HTTP_PORT=4080
export HOST_HTTPS_PORT=4443

echo "Building Dribly"

docker login

docker-compose -f ./docker-compose-prod-run.yml --project-name="${COMPOSE_PROJECT_NAME}" up

if [ $? -eq 0 ]
 then
    echo "All done. upping ${APP_NAME}  Hope it worked"
else
    echo "might have been a problem upping ${APP_NAME}"
fi


