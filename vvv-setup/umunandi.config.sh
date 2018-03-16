#!/bin/sh

# === umunandi.test setup script ===
# Configures the VVV VM to create the umunandi.test development server

# DIR vars
SCRIPT_DIR=$(cd "$(dirname "$0")"; pwd)
REPO_ROOT=$(cd "$SCRIPT_DIR/.."; pwd)
VVV_DIR=$(cd "$REPO_ROOT/../vvv"; pwd)
VVV_WEB_ROOT="$VVV_DIR/www"

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
