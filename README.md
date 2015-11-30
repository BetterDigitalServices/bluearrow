# Wordpress, Sage, Docker boilerplate

## Prepare boilerplate

These steps should be done only once when starting to use this boilerplate.

### Download latest Wordpress

	npm run download-wp

### Download latest [Sage](https://roots.io/sage/)

Replace THEME_NAME with your own theme name

	git clone --depth=1 --branch=master https://github.com/roots/sage.git wordpress/wp-content/themes/THEME_NAME
	rm -rf wordpress/wp-content/themes/THEME_NAME/.git

### Modify Dockerfile .gitignore and .dockerignore  ###

Replace all THEME_NAME occurrences in Dockerfile .gitignore and .dockerignore with your theme name.
You can do this with sed

	sed -i '' 's/THEME_NAME/NEW_NAME/g' Dockerfile .gitignore .dockerignore

### Commit everything

You can remove *Prepare boilerplate* steps from this README. The boilerplate is ready to be used. You can commit your changes.
The following installation steps should be done always when setting up a new development environment.

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
