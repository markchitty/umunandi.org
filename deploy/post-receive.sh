#!/bin/sh

# === umunandi.org deployment script ===
# Stored on the umunandi.org server at ~/umunandi.org.git/hooks/post-receive
# and run by git after a push from the local dev environment.
# Gleaned from http://serverfault.com/questions/458942/git-website-delopyment-including-submodules

# DIR VARS
GIT_REPO="/home/myfriend/umunandi.org.git"
WEB_ROOT="/home/myfriend/public_html"
WEB_BACKUP="$WEB_ROOT.bak"
WEB_CONTENT="$WEB_BACKUP/shared"

# Unset global GIT_DIR so script can leave repository
unset GIT_DIR

# Backup existing web root
rm -rf $WEB_BACKUP
mv $WEB_ROOT $WEB_BACKUP

# Recreate WEB_ROOT
mkdir $WEB_ROOT
chmod -R 755 $WEB_ROOT

# Clone git repository into web root
git clone $GIT_REPO $WEB_ROOT

# import submodules
cd $WEB_ROOT
git submodule init
git submodule update

# delete git repository and associated files in http dir and /wp subdir
rm -rf $WEB_ROOT/.git
rm -rf $WEB_ROOT/wp/.git
rm $WEB_ROOT/.git*

# Copy non-git-managed files back into new WEB_ROOT
cp -R $WEB_CONTENT $WEB_ROOT

# Set file and directory permissions otherwise nginx throws a 500 hissy
find . -type f -not -perm 0644 -exec chmod 644 {} \;
find . -type d -not -perm 0755 -exec chmod 755 {} \;
