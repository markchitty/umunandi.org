umunandi.org website development notes
======================================

This project uses [VVV](https://github.com/Varying-Vagrant-Vagrants/VVV)
(Varying Vagrant Vagrants) as the development environment. VVV is an open source
Vagrant configuration focused on WordPress development.

The project setup script is designed for Mac OSX. It could be ported to Windows,
but I don't use Windows so that's a job for someone else.

Dependencies
------------

Install the following:
+ [VirtualBox](https://www.virtualbox.org/wiki/Downloads) - Virtual machine container
+ [Vagrant](http://www.vagrantup.com) - Virtual machine environment confirguration tool

Setup
-----

Clone
[VVV](https://github.com/Varying-Vagrant-Vagrants/VVV)

Local dev environment runs on VVV virtual server in ~/Dropbox/Dev/Tools/vagrant. Run

`vagrant up`

to start the dev machine.

`vagrant`

will output all the vagrant help info.

VVV setup of VirtualBox VM tailored for Wordpress hosting. Customisations:

+ **`vagrant/www`**  
  Create the following empty folders to prevent installation of these Wordpress instances  
  ┣ `wordpress-default`  
  ┣ `wordpress-develop`  
  ┗ `wordpress-trunk`
+ **`vagrant/Customfile`**  
  Maps host path `../Projects/umunandi.org/umunandi.org-website`
  to VM path `/srv/www/umunandi/`
+ **`vagrant/umunandi-config`**  
  Contains hosts, MySQL and nginx setup instructions to create umunandi.dev website

/umunandi.org-website = git repositry based on

+ WordPress-Skeleton
  - https://github.com/markjaquith/WordPress-Skeleton
  - Copied not cloned - don't want the history
+ Roots theme
  - http://roots.io & https://github.com/roots/roots
  - Copied not cloned - don't want the history or to contribute directly
  - Renamed to Umunandi
+ WordPress as a submodule
+ Production server at umunandi.org set as remote for pushing to

Managed deployment configuration
--------------------------------
+ **Git repository on server** - http://toroid.org/ams/git-website-howto
+ **Public SSH key on server** - http://smbjorklund.no/ssh-login-without-password-using-os-x
+ **Post-receive git hook** - http://serverfault.com/questions/458942/git-website-delopyment-including-submodules
  - post-receive.sh
  - saved on server at ~/umunandi.org.git/hooks/post-receive (chmod 775)
  - checks out latest revision to /public_html and then removes .git files & dirs
+ **syncdb** - https://github.com/jplew/SyncDB
  - synchronizes non-git assets = DB & uploaded content
  - comprises syncdb (script) and syncdb-config (configuration)

### Deployment steps ###
1. **vagrant ssh** - Open a shell on the vagrant host server
2. **Run syncdb push** - `$ /srv/www/umunandi/syncdb push` to copy the development database and uploads (images etc) up to Live
   - Make sure you've first pulled down from Live any content that has been created on Live and doesn't exist on Dev
3. **Push latest git release** - Push the latest release in git up to umunandi.org remote
   - We're using gitflow so go through the correct procedure for creating a new release
