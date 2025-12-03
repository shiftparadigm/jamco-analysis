FROM wordpress:6.4-php8.1-apache

# Install Node.js (for building blocks), MySQL, and WP-CLI
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
    default-mysql-server \
    default-mysql-client \
    less \
    supervisor \
    curl \
    gnupg && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp && \
    a2enmod rewrite && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Enable .htaccess overrides for WordPress permalinks
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy Likewize theme
COPY theme /var/www/html/wp-content/themes/likewize

# Build theme blocks
WORKDIR /var/www/html/wp-content/themes/likewize
RUN npm install && \
    npm run build && \
    rm -rf node_modules && \
    npm cache clean --force
WORKDIR /var/www/html

# Copy database dump (optional - we use WP-CLI init instead)
# COPY db-init/wordpress.sql /tmp/wordpress.sql

# Copy WordPress uploads if they exist (optional)
# COPY db-init/uploads /var/www/html/wp-content/uploads

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/wp-content/themes/likewize && \
    chmod -R 755 /var/www/html/wp-content/themes/likewize

# Create supervisor config to run both MySQL and Apache
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy startup scripts
COPY start-services.sh /usr/local/bin/
COPY fix-urls.sh /usr/local/bin/
COPY init-wordpress.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start-services.sh /usr/local/bin/fix-urls.sh /usr/local/bin/init-wordpress.sh

EXPOSE 80

ENTRYPOINT []
CMD ["/usr/local/bin/start-services.sh"]
