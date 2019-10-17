lint:
	@test -f $$HOME/.cache/composer/phpstan-0.11.8.phar || (mkdir -p $$HOME/.cache/composer/ && wget https://github.com/phpstan/phpstan/releases/download/0.11.8/phpstan.phar -O $$HOME/.cache/composer/phpstan-0.11.8.phar)
	@php $$HOME/.cache/composer/phpstan-0.11.8.phar analyze -l 7 -c phpstan.neon ./src

docker-lint:
	@docker run -v $$PWD:/app --rm phpstan/phpstan analyze -l 7 -c phpstan.neon ./src

test:
	@php -derror_reporting="E_ALL & ~E_DEPRECATED" vendor/bin/phpunit

test-coverage:
	@php -derror_reporting="E_ALL & ~E_DEPRECATED" -dzend_extension=xdebug.so vendor/bin/phpunit --coverage-text

petstore-client:
	@rm -rf tests/src/Petstore/ && mkdir -p tests/src/Petstore/
	@swac php-guzzle-client https://raw.githubusercontent.com/OAI/OpenAPI-Specification/master/examples/v2.0/json/petstore.json --namespace Swaggest\\RestClient\\Tests\\Petstore --project-path tests/src/Petstore/
	@git add tests/src/Petstore/
