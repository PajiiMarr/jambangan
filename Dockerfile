FROM richarvey/nginx-php-fpm:latest

# Install Node.js for asset building
RUN apk add --update nodejs npm

COPY . .

# Ensure proper permissions
RUN chmod +x /var/www/html/start.sh

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Add custom nginx configuration for CORS
COPY conf/nginx/nginx-file.conf /etc/nginx/sites-available/default.conf

CMD ["/var/www/html/start.sh"]