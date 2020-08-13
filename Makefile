init:
	docker-compose exec php74-service composer install
	docker-compose exec php74-service bin/console doctrine:database:create --if-not-exists
	docker-compose exec php74-service bin/console doctrine:schema:update  --force
	docker-compose exec php74-service bin/console doctrine:fixture:load

run:
	cd front && sudo npm install
	cd front && npm run serve