FROM wordpress:4-apache

# This image requires that /var/www/ is set as a persistent volume in the container

# Add custom themes and plugins
ADD wordpress/wp-content/themes/bluearrow/ /usr/src/wordpress/wp-content/themes/bluearrow/
RUN chown -R www-data:www-data /usr/src/wordpress

# Hax Hax! Somehow HTTP_POST is returned in 'domain, domain' format. The root reason for this is uknown.
# We add line to wp-config.php that modifies the string to the correct format.
RUN sed -i.bak 's/.*<?php.*/<?php $_SERVER["HTTP_HOST"] = explode(",", $_SERVER["HTTP_HOST"])[0];/' /usr/src/wordpress/wp-config-sample.php

# Copy theme contents to www root
CMD mkdir -p  /var/www/html/wp-content/themes/ && yes | cp -rf /usr/src/wordpress/wp-content/themes/bluearrow /var/www/html/wp-content/themes && apache2-foreground
