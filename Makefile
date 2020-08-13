init:
	docker-compose exec php74-service bin/console doctrine:database:create --if-not-exists
	docker-compose exec php74-service bin/console doctrine:schema:update  --force
	docker-compose exec php74-service bin/console doctrine:fixture:load