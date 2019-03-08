#!/bin/sh



export APPLICATION=../
export CONTAINER_NAME_PREFIX="dribly-dev"
export COMPOSE_PROJECT_NAME="Dribly-Dev"


echo "Building Dribly"

if [ "$1" == "" ] || [ "$1" == "up" ]; then
   VERB="up"
elif [ "$1" == "down" ]; then
   VERB="down"
#   AFTER="--rmi v"
else
   VERB="$1"
fi
docker-compose -f docker-compose.yml --project-name="${COMPOSE_PROJECT_NAME}" $VERB $AFTER

if [ $? -eq 0 ]
 then
    echo "All done. ${VERB}-ing ${APP_NAME}  Hope it worked"
else
    echo "might have been a problem ${VERB}-ing ${APP_NAME}"
fi
