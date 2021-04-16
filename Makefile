start:
	php artisan serve

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 app routes tests

lint:
	composer run-script phpcs -- --standard=PSR12 app routes tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
