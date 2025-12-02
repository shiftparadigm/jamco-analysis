#!/bin/bash
set -e

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"$WORDPRESS_DB_HOST" --silent; do
    sleep 1
done

echo "MySQL is ready!"

# Check if WordPress is already installed
if ! wp core is-installed --allow-root 2>/dev/null; then
    echo "WordPress not installed, waiting for initial setup..."

    # Wait for WordPress core files to be ready
    sleep 10

    # Check if we should import the database
    if [ -f "/tmp/db-init/wordpress.sql" ] && [ ! -f "/tmp/db-imported" ]; then
        echo "Importing database..."
        wp db import /tmp/db-init/wordpress.sql --allow-root 2>/dev/null || true
        touch /tmp/db-imported
        echo "Database imported!"

        # Update site URLs
        SITE_URL="${WORDPRESS_CONFIG_EXTRA#*WP_HOME\', \'}"
        SITE_URL="${SITE_URL%%\'*}"

        if [ ! -z "$SITE_URL" ]; then
            echo "Updating site URLs to $SITE_URL..."
            wp search-replace 'http://localhost:8888' "$SITE_URL" --allow-root 2>/dev/null || true
            wp search-replace 'http://localhost' "$SITE_URL" --allow-root 2>/dev/null || true
        fi

        # Activate theme
        wp theme activate jamco --allow-root 2>/dev/null || true
        echo "Theme activated!"

        # Flush permalinks
        wp rewrite flush --allow-root 2>/dev/null || true
    fi
fi

# Execute the original WordPress entrypoint
exec docker-entrypoint.sh "$@"
