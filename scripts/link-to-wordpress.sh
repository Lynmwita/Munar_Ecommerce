#!/usr/bin/env bash
# Link Munar Theme & Plugin to both /opt/lampp/htdocs/wordpress and /opt/lampp/htdocs/munar
# Also fix max_allowed_packet in XAMPP my.cnf
set -e

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

echo " Linking Munar Plugin and Theme to XAMPP WordPress..."
sudo ln -sfn "$PROJECT_DIR/core-wp/wp-content/plugins/munar-daraja-mpesa" /opt/lampp/htdocs/wordpress/wp-content/plugins/munar-daraja-mpesa
sudo ln -sfn "$PROJECT_DIR/core-wp/wp-content/themes/munar-luxury" /opt/lampp/htdocs/wordpress/wp-content/themes/munar-luxury

echo "️ Fixing MySQL max_allowed_packet in /opt/lampp/etc/my.cnf..."
sudo sed -i 's/max_allowed_packet=1M/max_allowed_packet=64M/g' /opt/lampp/etc/my.cnf

echo " Done! Refresh your WordPress admin at http://localhost/wordpress/wp-admin"
