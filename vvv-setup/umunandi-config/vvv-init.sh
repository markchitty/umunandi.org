# Init script for umunandi.test

echo "Commencing Umunandi database setup"

# Make a database, if we don't already have one
echo "Creating database (if it's not already there)"
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS wp_umunandi"
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON wp_umunandi.* TO wp@localhost IDENTIFIED BY 'wp';"

# The Vagrant site setup script will restart Nginx for us

echo "Umunandi database now installed";
