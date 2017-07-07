COMPOSER ?= composer
PHPUNIT_OPTS =

app/config/parameters.yml:
	cp app/config/parameters.yml.dist app/config/parameters.yml

composer: app/config/parameters.yml
	$(COMPOSER) install

cc:
	rm -rf var/cache/*

clear: cc
	rm -rf build/* var/logs/*

test: cc composer
	SYMFONY_DEPRECATIONS_HELPER=weak phpunit $(PHPUNIT_OPTS)
