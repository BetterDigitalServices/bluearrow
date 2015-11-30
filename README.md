# Bluearrow wordpress

## Installation

### Prequisities

Working PHP and MySQL installation is required. Development does not require external http-server.

### Download latest wordpress

	npm run download-wp

### Configure wordpress

Create development database for wordpress and copy sample configuration as a base configuration

	cp wordpress/wp-content/wp-config-sample.php wordpres/wp-content/wp-config.php

Modify DB_NAME, DB_USER, DB_PASSWORD and DB_HOST to wp-config.php.
Please note that MySQL host should be 127.0.0.1 instead of localhost.

Install theme dependencies

	cd wordpress/wp-content/themes/THEME_NAME
	npm install && bower install

## Run development server

Start PHP development server (on root of the repository).

	npm start

## Build theme assets

	cd wordpress/wp-content/themes/THEME_NAME
	gulp build

## Compile theme styles and watch changes

	cd wordpress/wp-content/themes/THEME_NAME
	gulp watch

## Deployment

Build theme assets using instructions in the previous section.

This image requires that /var/www/ is set as a persistent volume in the container.

Create docker-machine environment if you do not have one yet. This needs to be done only once. Make sure that you have latest VirtualBox installed.

	docker-machine create -d virtualbox dev

Start the docker-machine and create the image.

	docker-machine start dev
	docker-machine env dev
	docker build -t index.sc5.io/PROJECT_NAME:latest .
	docker push index.sc5.io/PROJECT_NAME:latest
