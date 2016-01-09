umunandi.org website
====================

umunandi.org is the website for **Umunandi**, a UK based charity supporting orphans and vulnerable children in Zambia.

The website is built on WordPress, running

+ WordPress-Skeleton ([https://github.com/markjaquith/WordPress-Skeleton](https://github.com/markjaquith/WordPress-Skeleton))
  - Copied not cloned - don't want the history
+ Roots theme ([http://roots.io](http://roots.io) & [https://github.com/roots/roots](https://github.com/roots/roots))
  - Copied not cloned - don't want the history or to contribute directly
  - Renamed to Umunandi
+ WordPress as a submodule

Development environment
-----------------------

+ Vagrant ([http://www.vagrantup.com](http://www.vagrantup.com))
  - Virtual machine configuration tool
+ VirtualBox ([https://www.virtualbox.org](https://www.virtualbox.org))
  - Virtual machine container (like an open source version of VMWare)
+ VVV = Varying Vagrant Vagrants ([https://github.com/Varying-Vagrant-Vagrants/VVV](https://github.com/Varying-Vagrant-Vagrants/VVV))
  - an open source Vagrant configuration focused on WordPress development.

Dependencies
------------

Follow the instructions at [https://github.com/Varying-Vagrant-Vagrants/VVV](https://github.com/Varying-Vagrant-Vagrants/VVV)
and install the following:

1. [VirtualBox](https://www.virtualbox.org/wiki/Downloads) - Virtual machine container
1. [Vagrant](http://www.vagrantup.com) - Virtual machine environment confirguration tool
1. [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater) plugin
    - `vagrant plugin install vagrant-hostsupdater`
1. [vagrant-triggers](https://github.com/emyl/vagrant-triggers) plugin
    - `vagrant plugin install vagrant-triggers`

Setup
-----

1. Create the following folder structure for the project in a suitable location on your machine  
    `┗ umunandi`  
    `  ┣ umunandi.org`  
    `  ┗ vvv`
1. Make sure you're in the parent `umunandi/` folder
    - `cd umunandi`
1. Clone Varying Vagrant Vagrants into `umunandi/vvv`
    - `git clone git://github.com/Varying-Vagrant-Vagrants/VVV.git vvv`
1. Clone this umunandi.org repo into `umunandi/umunandi.org`
    - `git clone git://github.com/markchitty/umunandi.org umunandi.org`
1. Run the umunandi.dev setup script. This configures VVV to set up the umunandi.dev development site.
    - `./umunandi.org/vvv-setup/umunandi.dev.sh`
    - You should see 5 additional directories appear in the `umunandi/vvv` folder
1. Switch to the `umunandi/vvv` directory and run `vagrant up` to provision the dev machine. This may take some time (minutes)
   to download the VM image and configure it.
    - `cd vvv`
    - `vagrant up`

Run `vagrant` to output further vagrant help info.


Managed deployment configuration
--------------------------------
The production server at umunandi.org is set as a git remote for pushing to

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
