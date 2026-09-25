#!/usr/bin/env bash
# Symlink Munar WordPress instance to XAMPP htdocs
set -e

HTDOCS_MUNAR="/opt/lampp/htdocs/munar"
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)/core-wp"

echo "🔗 Linking $PROJECT_DIR -> $HTDOCS_MUNAR ..."
if [ -L "$HTDOCS_MUNAR" ] || [ -d "$HTDOCS_MUNAR" ]; then
    sudo rm -rf "$HTDOCS_MUNAR"
fi

sudo ln -s "$PROJECT_DIR" "$HTDOCS_MUNAR"
echo "✅ Munar E-Commerce linked successfully! Accessible at: http://localhost/munar"
