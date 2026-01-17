#!/bin/bash

# This script is executed once when the plugin is installed.

PLUGIN_DIR="/usr/local/emhttp/plugins/publicip"
SRC_DIR="/boot/config/plugins/publicip"

# Create the plugin directory
mkdir -p "$PLUGIN_DIR"

# Copy the plugin files from the installation source to the plugins directory
cp "$SRC_DIR/publicip.php" "$PLUGIN_DIR/"
cp "$SRC_DIR/publicip.js" "$PLUGIN_DIR/"
cp "$SRC_DIR/get_public_ip.sh" "$PLUGIN_DIR/"

# Make the shell script executable
chmod +x "$PLUGIN_DIR/get_public_ip.sh"

echo "Public IP plugin installed."