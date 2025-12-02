#!/bin/bash

# Wait for MySQL and Apache to be fully ready
sleep 10

# Get the target URL (from environment or default to http://localhost)
TARGET_URL="${SITE_URL:-http://localhost}"

echo "Updating WordPress site URLs to: $TARGET_URL"

# Update site URLs in database
mysql -h 127.0.0.1 -uwordpress -pwordpress wordpress -e "UPDATE wp_options SET option_value='$TARGET_URL' WHERE option_name IN ('siteurl', 'home');"

echo "Configuring permalink structure for REST API..."

# Set permalink structure to support REST API
mysql -h 127.0.0.1 -uwordpress -pwordpress wordpress -e "UPDATE wp_options SET option_value='/%postname%/' WHERE option_name='permalink_structure';"

# Set rewrite rules option
mysql -h 127.0.0.1 -uwordpress -pwordpress wordpress -e "DELETE FROM wp_options WHERE option_name='rewrite_rules';"

echo "URLs and permalinks updated successfully"

echo "Resetting admin password with WP-CLI..."
# Wait longer for WordPress to be fully ready
sleep 10

# Reset password using WP-CLI
cd /var/www/html
if wp user list --allow-root --field=user_login 2>/dev/null | grep -q "^admin$"; then
    wp user update admin --user_pass='JamcoAdmin2024!' --allow-root --skip-email 2>&1 || echo "WP-CLI update failed"
else
    echo "Admin user not found, using original password from database"
fi

echo "Admin credentials: admin / JamcoAdmin2024! (or original password)"
