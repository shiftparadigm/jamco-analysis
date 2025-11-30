#!/bin/bash
#
# Populate WordPress with Premium Seating content
# This uploads images and creates all content blocks programmatically
#

cd "$(dirname "$0")/.." || exit

echo "Populating WordPress content..."
npm run wp-env -- run cli wp eval-file wp-content/themes/jamco/populate-content.php

echo ""
echo "Done! View the page at: http://localhost:8888/premium-seating/"
