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

## Storing Previous Years Versions of the Website

The following will create a static copy of the website. Note that all the links are not necessarily beautiful.

    > wget -N --recursive --page-requisites --html-extension https://www.bluearrowawards.com

## Updating Letsencrypt Certificates

The certificates for this site have been generated using http://www.letsencrypt.org/. This means you need to renew your certificate every three months - don't forget to do that!

In practice what you need to do is run letsencrypt cli every few months, follow the console instructions on what challenge key you'll upload into .well-known/acme-challenge, and re-deploy your website. The following long instructions help you forward:

1. Start `certbot` (the new letesencrypt client), choose  `www.bluearrowawards.com` for the domain.


    > git clone git@github.com:certbot/certbot.git
    > cd certbot
    > sudo ./certbot-auto certonly --debug --manual

2. Follow the certbot instructions, e.g. copy the certbot verification string into root-level `.well-known/acme-challenge` directory while the process is still running.


    > echo jRWhFIQGLP0MNIBL_1HMBvQEziW5Ss5bqsP8rSFcn-c.LKsscNwqNHbCdkVCcX9XTg570zfIQu6CkPBPISFc3hI >.well-known/acme-challenge/jRWhFIQGLP0MNIBL_1HMBvQEziW5Ss5bqsP8rSFcn-c

3. Update the new version into AppEngine - the easiest way is likely the AppEngine client (see above).

4. Let certbot finish its job, then save & Store the generated certificates.

5) Update the certbot created private key into RSA form:
    > openssl rsa -in privkey.pem >privkey-rsa.pem

6) Navigate to Google Cloud console (https://cloud.google.com/), bluearrowawards-1158 project, then `Dashboard->Resources->App Engine->Settings->SSL Certificates->Upload new certificate`. Choose the generated key (e.g. `fullchain.pem` and the RSA private key (e.g. `privkey-rsa.pem`). Finish the SSL certificate creation dialog.
