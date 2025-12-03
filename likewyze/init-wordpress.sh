#!/bin/bash
##
# Initialize WordPress for Likewize
# This script sets up WordPress, activates the theme, and creates content
##

set -e

echo "🚀 Initializing Likewize WordPress..."

# Wait for MySQL to be ready
until mysql -h127.0.0.1 -uwordpress -pwordpress -e "SELECT 1" &>/dev/null; do
    echo "⏳ Waiting for MySQL..."
    sleep 2
done

echo "✅ MySQL is ready"

# Create database if it doesn't exist
mysql -h127.0.0.1 -uwordpress -pwordpress -e "CREATE DATABASE IF NOT EXISTS wordpress CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

cd /var/www/html

# Install WordPress if not already installed
if ! wp core is-installed --allow-root 2>/dev/null; then
    echo "📦 Installing WordPress..."

    wp core install \
        --url="${SITE_URL:-http://localhost}" \
        --title="Likewize Device Protection" \
        --admin_user=admin \
        --admin_password=JamcoAdmin2024! \
        --admin_email=admin@likewize.local \
        --skip-email \
        --allow-root

    echo "✅ WordPress installed"
fi

# Activate Likewize theme
echo "🎨 Activating Likewize theme..."
wp theme activate likewize --allow-root

# Delete default content
echo "🗑️  Removing default content..."
wp post delete 1 2 3 --force --allow-root 2>/dev/null || true
wp post delete $(wp post list --post_type=page --format=ids --allow-root) --force --allow-root 2>/dev/null || true

# Create Device Protection page with blocks
echo "📄 Creating Device Protection page..."

# Create page with Gutenberg blocks
wp post create \
    --post_type=page \
    --post_title='Device Protection' \
    --post_name='device-protection' \
    --post_status=publish \
    --page_template='' \
    --allow-root \
    --post_content='<!-- wp:likewize/hero /-->

<!-- wp:likewize/feature-grid /-->

<!-- wp:likewize/process-steps /-->

<!-- wp:likewize/pricing-table /-->

<!-- wp:likewize/faq-accordion /-->'

# Set as homepage
PAGE_ID=$(wp post list --post_type=page --name=device-protection --field=ID --allow-root)
wp option update show_on_front 'page' --allow-root
wp option update page_on_front "$PAGE_ID" --allow-root

# Update permalink structure
echo "🔗 Setting permalink structure..."
wp rewrite structure '/%postname%/' --allow-root
wp rewrite flush --allow-root

# Update site settings
wp option update blogdescription "Comprehensive device protection coverage" --allow-root
wp option update timezone_string "America/New_York" --allow-root

echo "✅ Likewize WordPress initialized successfully!"
echo ""
echo "🌐 Site URL: ${SITE_URL:-http://localhost}"
echo "👤 Admin: admin"
echo "🔑 Password: JamcoAdmin2024!"
echo ""
