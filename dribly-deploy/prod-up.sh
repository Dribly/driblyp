#!/bin/sh


export APPLICATION=../
export CONTAINER_NAME_PREFIX="dribly-prod"
export COMPOSE_PROJECT_NAME="Dribly-Prod"

echo "Building Dribly"

if [ ! -d ./storage ]; then
    mkdir storage
fi
if [ ! -d ./storage/framework ]; then
    mkdir storage/framework
fi
if [ ! -d ./storage/app ]; then
    mkdir storage/app
fi
if [ ! -d ./storage/framework/cache ]; then
    mkdir storage/framework/cache
fi
if [ ! -d ./storage/framework/sessions ]; then
    mkdir storage/framework/sessions
fi
if [ ! -d ./storage/framework/views ]; then
    mkdir storage/framework/views
fi

export BUILDID=$(<buildid.txt)

#docker login
##docker-compose -f ./docker-compose-prod-run.yml --project-name="${COMPOSE_PROJECT_NAME}" pull
echo "pulling build ${BUILDID}"

#docker pull powellblyth/dribly:${BUILDID}
#docker pull powellblyth/dribly-nginx:${BUILDID}
#docker pull powellblyth/dribly-workspace:${BUILDID}
#docker pull powellblyth/dribly-mqtt-listener:${BUILDID}

docker-compose -f ./docker-compose-prod-run.yml --project-name="${COMPOSE_PROJECT_NAME}" up

if [ $? -eq 0 ]
 then
    echo "All done. upping ${APP_NAME}  Hope it worked"
else
    echo "might have been a problem upping ${APP_NAME}"
fi


