#!/bin/bash
set -e

echo "Starting MySQL initialization..."

# Create MySQL socket directory
mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld

# Initialize MySQL data directory if needed
if [ ! -d "/var/lib/mysql/mysql" ]; then
    echo "Initializing MySQL data directory..."
    mysqld --initialize-insecure --user=mysql --datadir=/var/lib/mysql
fi

# Start MySQL temporarily for setup
echo "Starting MySQL for setup..."
mysqld --user=mysql --datadir=/var/lib/mysql &
MYSQL_PID=$!

# Wait for MySQL to be ready
echo "Waiting for MySQL to start..."
for i in {1..30}; do
    if mysqladmin ping --silent; then
        echo "MySQL is ready!"
        break
    fi
    sleep 1
done

# Create database and user
echo "Creating WordPress database..."
mysql -e "CREATE DATABASE IF NOT EXISTS wordpress;"
mysql -e "CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';"
mysql -e "GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# Import database if it exists and hasn't been imported
if [ -f "/tmp/wordpress.sql" ] && [ ! -f "/tmp/.db-imported" ]; then
    echo "Importing WordPress database..."
    mysql wordpress < /tmp/wordpress.sql
    touch /tmp/.db-imported
    echo "Database imported successfully!"
fi

# Stop temporary MySQL
kill $MYSQL_PID
wait $MYSQL_PID 2>/dev/null || true

# Set WordPress database config for Apache
cat >> /etc/apache2/envvars <<'ENVEOF'
export WORDPRESS_DB_HOST=localhost
export WORDPRESS_DB_NAME=wordpress
export WORDPRESS_DB_USER=wordpress
export WORDPRESS_DB_PASSWORD=wordpress
ENVEOF

# Copy WordPress files if needed
if [ ! -e /var/www/html/index.php ]; then
    echo "Setting up WordPress files..."
    cp -a /usr/src/wordpress/. /var/www/html/
    chown -R www-data:www-data /var/www/html
fi

# Create .htaccess for WordPress permalinks
echo "Creating .htaccess for permalinks..."
cat > /var/www/html/.htaccess <<'HTACCESS'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
HTACCESS
chown www-data:www-data /var/www/html/.htaccess

# Create wp-config.php
echo "Creating wp-config.php..."
cat > /var/www/html/wp-config.php <<'WPCONFIG'
<?php
// Handle HTTPS from reverse proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

// Force HTTPS for admin
define('FORCE_SSL_ADMIN', true);

define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'wordpress' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

$table_prefix = 'wp_';

define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
WPCONFIG
chown www-data:www-data /var/www/html/wp-config.php

# Start supervisor to run both MySQL and Apache
echo "Starting MySQL and Apache via supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
