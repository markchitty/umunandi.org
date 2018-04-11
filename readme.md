# umunandi.org website

umunandi.org is the website for **Umunandi**, a UK based charity supporting orphans and vulnerable children in Zambia.

The website is a WordPress site, built on the Roots theme <http://roots.io> & <https://github.com/roots/roots> (now deprecated and replace by [Sage](https://github.com/roots/sage)).

## Development environment

+ VirtualBox <https://www.virtualbox.org> - Virtual machine container (open source VMWare equivalent)
+ Vagrant <http://www.vagrantup.com> - Virtual machine configuration tool
+ VVV = Varying Vagrant Vagrants <https://github.com/Varying-Vagrant-Vagrants/VVV> - an open source Vagrant configuration focused on WordPress development (version 1.4.1)

## Dependencies

Follow the instructions at <https://github.com/Varying-Vagrant-Vagrants/VVV> and install the following:

1. [VirtualBox](https://www.virtualbox.org/wiki/Downloads) - Virtual machine container
1. [Vagrant](http://www.vagrantup.com) - Virtual machine environment confirguration tool
1. [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater) plugin - `vagrant plugin install vagrant-hostsupdater`
1. [vagrant-triggers](https://github.com/emyl/vagrant-triggers) plugin - `vagrant plugin install vagrant-triggers`

## Setup

1. **Create project home** - Create a parent folder for the project and `cd` into it  
`$ mkdir umunandi`  
`$ cd umunandi`

1. **Get umunandi.org** - Clone this repo into a new folder */umunandi.org*  
`$ git clone git://github.com/umunandi/umunandi.org umunandi.org`

1. **Get VVV** - Clone Varying Vagrant Vagrants into */vvv* and checkout v1.4.1  
`$ git clone git://github.com/Varying-Vagrant-Vagrants/VVV.git vvv`  
`$ cd vvv`  
`$ git checkout tags/1.4.1 -b 1.4.1`

1. **Configure dev env** - Run the `umunandi.config.sh` config script   
`$ ../umunandi.org/vvv-setup/umunandi.config.sh`  
This prepares the VVV vm to create a new *umunandi.test* web site.

1. **Provision dev machine** - Run:  
`$ vagrant up`  
This downloads the VM image and configures it (may take a few mins). The vagrant provisioning script will ask you for your password so that it can update your hosts file with local DNS entries for *umunandi.test*. To read more about vagrant and what it can do, run `vagrant` from the vvv directory.

1. Point your browser to <http://umunandi.test> to browse the website. The WordPress admin page is available at <http://umunandi.test/wp-admin>. You can login with [VVV's default credentials](https://varyingvagrantvagrants.org/docs/en-US/default-credentials/).

2. The Umunandi site is built as a WordPress theme based on [Roots](https://roots.io/). Roots uses *grunt* to build js and less/css assets. To install and run grunt:

```
$ cd ./umunandi.org/web/app/themes/umunandi
$ npm install   // installs grunt
$ grunt watch   // watch task dynamically recompiles less and js assets
```

## Updating WordPress
[Roots uses Composer](https://roots.io/using-composer-with-wordpress/) to manage dependencies such as WordPress plugins, and indeed WordPress itself. To update WordPress and/or plugins **don't** use the WordPress admin UI. Instead, edit *composer.json* and update the relevant version numbers for the dependencies you want to update. Once you've done that, log in to vvv ...

```
$ cd vvv
$ vagrant ssh       // Log in to the VM
$ cd umunandi.test
```
... and then from the vvv vm:

1. Backup the database (always backup the database) using [wp-cli](https://wp-cli.org/). (The */temp* folder is gitignore'd).  
`$ wp db export temp/umunandi-db-yyyy-mm-dd.sql`

1. Update WordPress - this will fetch the new version of WordPress you specified when you edited *composer.json*  
`$ composer update johnpbloch/wordpress*`

1. Test <http://umunandi.test> is still working

1. Update everything else (= plugins)  
`$ composer update`

1. Test <http://umunandi.test> is still working


## Managed deployment configuration

We deploy from *dev* to *prod* using git, as described by various [clever people](http://toroid.org/ams/git-website-howto) on the interweb.

####Git repository on server

On the server we create a [bare repositry](http://www.saintsjd.com/2011/01/what-is-a-bare-git-repository/) in the server home directory.

```
$ mkdir umunandi.org.git && cd umunandi.org.git
$ git init --bare
```



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
