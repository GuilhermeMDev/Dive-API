init: ## Start a new develop environment
	$(MAKE) install
	$(MAKE) keys
	$(MAKE) fresh
	$(MAKE) seed

keys: ## Generate secret keys
	docker-compose exec docker-php-nginx bash -c "su -c 'php artisan key:generate' application"

install: ## Composer install dependencies
	docker-compose exec docker-php-nginx bash -c "su -c \"composer install\" application"

##@ Database tools

migration: ## Create migration file
	docker-compose exec docker-php-nginx bash -c "su -c \"php artisan make:migration $(name)\" application"

migrate: ## Perform migrations
	docker-compose exec docker-php-nginx php artisan migrate

storeall: ## Perform migrations
	docker-compose exec docker-php-nginx php artisan coins:storeAll

horizon: ## Start laravel horizon
	docker-compose exec -u application docker-php-nginx php artisan horizon

fresh: ## Perform fresh migrations
	docker-compose exec docker-php-nginx php artisan migrate:fresh

seed: ## Import database
	docker-compose exec docker-php-nginx php artisan db:seed

rollback: ## Rollback migration
	docker-compose exec docker-php-nginx php artisan migrate:rollback

reapply: ## Reapply the last migrations
	docker-compose exec docker-php-nginx php artisan migrate:rollback
	docker-compose exec docker-php-nginx php artisan migrate

backup: ## Export database
	docker-compose exec docker-php-mysql bash -c "mysqldump -u root -p database > /var/www/database/dumps/backup.sql"
	docker-compose exec docker-php-mysql bash -c "chown 1000:1000 /var/www/database/dumps/backup.sql"

restore: ## Import database
	docker-compose exec docker-php-mysql bash -c "mysql -u root -p database < /var/www/database/dumps/backup.sql"

route: ## Rollback migration
	docker-compose exec docker-php-nginx php artisan route:list

##@ Composer
autoload: ## Run the composer dump
	docker-compose exec docker-php-nginx bash -c "su -c \"composer dump-autoload\" application"
##@ Bash controls

bash: ## Start nginx bash
	docker-compose exec docker-php-nginx bash

nginx: ## Start nginx bash
	docker-compose exec -u application docker-php-nginx bash

mysql: ## Start mysql bash
	docker-compose exec docker-php-mysql bash