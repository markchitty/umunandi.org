![Umunandi logo](http://umunandi.dev/content/themes/umunandi/assets/img/umunandi-logo-370.png)

# umunandi.org website

umunandi.org is the website for **Umunandi**, a UK based charity supporting orphans and vulnerable children in Zambia.

The website is built on WordPress, running

+ WordPress-Skeleton <https://github.com/markjaquith/WordPress-Skeleton> - copied not cloned (don't want the history). Uses WordPress as a submodule.
+ Roots theme <http://roots.io> & <https://github.com/roots/roots>. Theme renamed to Umunandi.

## Development environment

+ VirtualBox <https://www.virtualbox.org> - Virtual machine container (open source VMWare equivalent)
+ Vagrant <http://www.vagrantup.com> - Virtual machine configuration tool
+ VVV = Varying Vagrant Vagrants <https://github.com/Varying-Vagrant-Vagrants/VVV> - an open source Vagrant configuration focused on WordPress development

## Dependencies

Follow the instructions at <https://github.com/Varying-Vagrant-Vagrants/VVV> and install the following:

1. [VirtualBox](https://www.virtualbox.org/wiki/Downloads) - Virtual machine container
1. [Vagrant](http://www.vagrantup.com) - Virtual machine environment confirguration tool
1. [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater) plugin - `vagrant plugin install vagrant-hostsupdater`
1. [vagrant-triggers](https://github.com/emyl/vagrant-triggers) plugin - `vagrant plugin install vagrant-triggers`

## Setup

Create this folder structure for the project and then cd into the parent folder

```
┗ umunandi
  ┣ umunandi.org
  ┗ vvv
  
$ cd umunandi
```

1. Clone Varying Vagrant Vagrants into /vvv
    - `$ git clone git://github.com/Varying-Vagrant-Vagrants/VVV.git vvv`
1. Clone this umunandi.org repo into /umunandi.org
    - `$ git clone git://github.com/markchitty/umunandi.org umunandi.org`
1. Run the umunandi.dev setup script. This configures VVV to set up the umunandi.dev development site.
    - `$ ./umunandi.org/vvv-setup/umunandi.dev.sh`
    - You should see 5 additional directories appear in the /vvv folder
1. Provision the dev machine. This may take some time (minutes)
   to download the VM image and configure it.
    - `$ cd vvv; vagrant up`

Run `vagrant` to output further vagrant help info.


## Managed deployment configuration

The production server at umunandi.org is set as a git remote for pushing to

+ **Git repository on server** - <http://toroid.org/ams/git-website-howto>
+ **Public SSH key on server** - <http://smbjorklund.no/ssh-login-without-password-using-os-x>
+ **Post-receive git hook** - <http://serverfault.com/questions/458942/git-website-delopyment-including-submodules>
  - post-receive.sh
  - saved on server at *~/umunandi.org.git/hooks/post-receive* (chmod 775)
  - checks out latest revision to *~/public_html* and then removes .git files & dirs
+ **syncdb** - <https://github.com/jplew/SyncDB>
  - Synchronizes non-git assets = WP database & uploaded content
  - *syncdb* script and configuration file *syncdb-config* live in *umunandi.org/web-root*
  - SyncDB must be from the webroot directory within the vvv vm  
    `$ cd vvv; vagrant ssh` - open a shell on the vvv vm  
    `$ cd /srv/www/umunandi` - cd to the webroot directory  
    `$ ./syncdb help` - show the list of SyncDB commands

### Deployment steps

There's a challenge here in terms of data management. Site content updates are made on the **live** site - new posts, etc. Site development updates are made on the **dev** site - new plugins, functionality etc. Both types of changes affect the database. When deploying new changes from dev => live how do we push the new dev DB changes to the live DB without overriding any content changes that have happened on live?

The ideal solution would be for dev DB changes to be scripted and the SQL scripts to be replayed on the live DB, thereby injecting the new DB content/structure without disrupting the existing content.

For now, the only approach is to sync down the DB from live => dev on a regular basis and especially prior to doing a code update. I'm *preeeety* sure this is going to bite me in the ass at some point, but I guess I'll have to deal with that when it happens.

#### Pull

1. `$ cd vvv; vagrant ssh` - Open a shell on the vvv vm
2. `$ /srv/www/umunandi/syncdb pull` - run *syncdb pull* to copy the live database and uploads (images etc) down locally

#### Push

1. `$ cd vvv; vagrant ssh` - Open a shell on the vvv vm
2. `$ /srv/www/umunandi/syncdb push` - run *syncdb push* to copy the local database and uploads (images etc) up to the live server
3. Push the latest release in git up to umunandi.org remote
   - We're using gitflow so go through the correct procedure for creating a new release
