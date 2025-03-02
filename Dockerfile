FROM php:8-fpm-alpine

# Standard development php.ini aktiv setzen
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# PHP.ini Sondereinstellungen kopieren
COPY dev/php-develop.ini "$PHP_INI_DIR/conf.d"

# Install-PHP-Extensions Programm installieren
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# XDebug und Composer installieren
RUN install-php-extensions xdebug @composer

# Arbeitsverzeichnis setzen
WORKDIR /var/www/html

# Composer-Einstellungen kopieren und validieren
COPY composer.json /var/www/html/
RUN composer validate --strict

# Schreibberechtigungen auf die Log- und Tmp-Ordner setzen
RUN chown -R www-data /var/log
RUN chown -R www-data /tmp

# Angemeldeten Benutzer einstellen
USER www-data