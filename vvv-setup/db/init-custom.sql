# Create the wp_umunandi database

# This file was originally copied from vvv/database/init-custom.sql.sample.
# It's copied back into that location as init-custom.sql by umunandi.config.sh.
# Vagrant will run the SQL commands below on startup, and then import any SQL
# files in the database/backups directory (provided the target DB is empty).
# See comments at the top of vvv/database/import-sql.sh for more details.

CREATE DATABASE IF NOT EXISTS `wp_umunandi`;
GRANT ALL PRIVILEGES ON `wp_umunandi`.* TO 'wp'@'localhost' IDENTIFIED BY 'wp';
