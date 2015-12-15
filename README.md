# Bluearrow wordpress

## Installation

### Prequisities

Working PHP and MySQL installation is required. Development does not require external http-server.

### Download latest wordpress

	npm run download-wp

### Configure wordpress

Create development database for wordpress and copy sample configuration as a base configuration

	cp wp-config.php wordpress/wp-config.php

Modify DB_NAME, DB_USER, DB_PASSWORD and DB_HOST to wp-config.php for local host setup.
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

Note: If you want to use the bundled BrowserSync to see live changes when
editing, modify wordpress/wp-content/themes/THEME_NAME/assets/manifest.json
path to match the port you are running Wordpress on (e.g. 8080).

## Deployment

### Deployment using Google App Engine using GUI

Once you have the applications up & running, developing and deploying using Google App engine is one-minute operation.

* [Download and install Google App Engine SDK for PHP](https://cloud.google.com/appengine/downloads#Google_App_Engine_SDK_for_PHP)
* Start Google App Engine Launcher
* Open this project
* Click "Deploy" (will delegate you to OAUTH authentication)

If you want to set up the system from scratch, follow these 15-minute instructions:

* Follow the [WP quick start instructions for App Engine](https://googlecloudplatform.github.io/appengine-php-wordpress-starter-project/)


### Deployment using Docker

Build theme assets using instructions in the previous section.

This image requires that /var/www/ is set as a persistent volume in the container.

Create docker-machine environment if you do not have one yet. This needs to be done only once. Make sure that you have latest VirtualBox installed.

	docker-machine create -d virtualbox default

Start the docker-machine and create the image.

	mv Dockerfile.tmpl Dockerfile # Renamed to avoid app engine conflicts
	docker-machine start default
	eval "$(docker-machine env default)"
	docker build -t bdsfinland/bluearrow:latest .
	docker push bdsfinland/bluearrow:latest
