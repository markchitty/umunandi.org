#!/bin/sh

# === umunandi.test setup script ===
# Configures the VVV VM to create the umunandi.test development server

# DIR vars
SCRIPT_DIR=$(cd "$(dirname "$0")"; pwd)
REPO_ROOT=$(cd "$SCRIPT_DIR/.."; pwd)
VVV_DIR=$(cd "$REPO_ROOT/../vvv"; pwd)
VVV_WEB_ROOT="$VVV_DIR/www"
VVV_DB_ROOT="$VVV_DIR/database"

# Copy wordpress-* folders to vvv/www to prevent installation of vvv's default Wordpress instances
cp -R $SCRIPT_DIR/wordpress-* "$VVV_WEB_ROOT"

# Prepare the umunandi.test WordPress site using VVV's auto site setup method
# https://github.com/varying-vagrant-vagrants/vvv/wiki/Auto-site-Setup
# To make this happen, copy the umunandi-config folder (and contents) to vvv/www
cp -R "$SCRIPT_DIR/umunandi-config" "$VVV_WEB_ROOT"

# Map the host path umunandi.org/web-root to the VM web-root folder created above.
# We do this by creating a file vvv/www/Customfile which contains the vagrant config
# instruction below. VVV runs this file automatically as part of its setup script.
CUSTOMFILE="$VVV_DIR/Customfile"
CUSTOMFILE_CONFIG="config.vm.synced_folder \"$REPO_ROOT\", \"/home/vagrant/umunandi.test/\", :owner => \"www-data\", :mount_options => [ \"dmode=775\", \"fmode=774\" ]"
echo "$CUSTOMFILE_CONFIG" > "$CUSTOMFILE"

# Environment variables are read by dot-env from config/environments/.env .
# This file is git-ignored (as it's different in every environment) so for dev
# we copy config/environments/.env.dev to config/environments/.env .
cp $REPO_ROOT/config/environments/.env.dev $REPO_ROOT/config/environments/.env

# Database import - relies on:
# - vvv/database/init-custom.sql - creates the wp_umunandi database
# - vvv/database/backups/wp_umunandi.sql - recent db backup that vvv imports
# We have to put those files in the right place:
cp "$SCRIPT_DIR/db/init-custom.sql" "$VVV_DB_ROOT"
cp "$SCRIPT_DIR/db/wp_umunandi.sql" "$VVV_DB_ROOT/backups"
