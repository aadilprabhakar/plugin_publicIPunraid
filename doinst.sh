#!/bin/bash
set -ex # Exit immediately on error, print all commands to the log

# This script is executed once when the plugin is installed.

PLUGIN_DIR="/usr/local/emhttp/plugins/publicip"
SRC_DIR="/boot/config/plugins/publicip"

echo "--- Starting Public IP Plugin Installation ---"

# Verify source files exist before copying
echo "Verifying source directory: $SRC_DIR"
ls -la "$SRC_DIR"

# Create the plugin directory
echo "Creating plugin directory: $PLUGIN_DIR"
mkdir -p "$PLUGIN_DIR"

# Copy the plugin files from the installation source to the plugins directory
echo "Copying files from $SRC_DIR to $PLUGIN_DIR"
cp "$SRC_DIR/publicip.php" "$PLUGIN_DIR/"
cp "$SRC_DIR/publicip.js" "$PLUGIN_DIR/"
cp "$SRC_DIR/get_public_ip.sh" "$PLUGIN_DIR/"

# Make the shell script executable
echo "Setting executable permission for get_public_ip.sh"
chmod +x "$PLUGIN_DIR/get_public_ip.sh"

# Verify files were copied correctly
echo "Verifying destination directory: $PLUGIN_DIR"
ls -la "$PLUGIN_DIR"

echo "--- Public IP plugin installed successfully ---"
