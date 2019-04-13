# Init script for umunandi.test

# Run Composer
echo "Running composer install"
composer install -d /home/vagrant/umunandi.test --prefer-dist

# The Vagrant site setup script will restart Nginx for us
