#!/bin/bash

# Wait for MySQL and Apache to be fully ready
sleep 10

# Get the target URL (from environment or default to http://localhost)
TARGET_URL="${SITE_URL:-http://localhost}"

echo "Updating WordPress site URLs to: $TARGET_URL"

# Update site URLs in database
mysql -h 127.0.0.1 -uwordpress -pwordpress wordpress -e "UPDATE wp_options SET option_value='$TARGET_URL' WHERE option_name IN ('siteurl', 'home');"

echo "URLs updated successfully"
