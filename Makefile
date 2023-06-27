#!/bin/bash
DOCKER_BE = shoppingcar_floraqueen-php-1
UID = $(shell id -u)

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

docker-up: ## Docker compose up
	U_ID=${UID} docker-compose up -d --build

docker-down: ## Docker compose down
	U_ID=${UID} docker-compose down

docker-ps: # Delete all volumes
	U_ID=${UID} docker ps -a -q

docker-prune: ## Delete all images of the containers
	U_ID=${UID} docker system prune -a
	U_ID=${UID} docker network prune

docker-rm: # Delete all volumes
	U_ID=${UID} docker stop $(docker ps -a -q)
	U_ID=${UID} docker rm -f $(docker ps -a -q)

docker-restart: ## Restart all containers
	U_ID=${UID} docker-compose down && docker-compose up --build

sh: ## ssh into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} sh