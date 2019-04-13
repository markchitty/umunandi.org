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
`$ mkdir umunandi && $ cd umunandi`

1. **Get umunandi.org** - Clone this repo into a new folder *{project_home}/umunandi.org*  
`$ git clone git://github.com/umunandi/umunandi.org umunandi.org`

1. **Get VVV** - Clone Varying Vagrant Vagrants into *{project_home}/vvv* and checkout v1.4.1  
`$ git clone git://github.com/Varying-Vagrant-Vagrants/VVV.git vvv`  
`$ cd vvv`  
`$ git checkout tags/1.4.1 -b 1.4.1`

1. **Configure dev VM** - Run the `umunandi.config.sh` config script   
`$ ../umunandi.org/vvv-setup/umunandi.config.sh`  
This prepares the VVV vm so it will create a new *umunandi.test* web site when provisioned.

1. **Provision dev machine** - Run `$ vagrant up`. This does a bunch of clever VVV stuff including:
   * Downloads the VirtualBox VM image (takes a few mins)
   * Updates it with current packages
   * Updates your local hosts file (provided you've installed *vagrant-hostsupdater*) - requires your pw
   * Maps the relevant folders in your project into the VM
   * Configures nginx with an umunandi.test website, including self-hosted SSL certs
   * Imports the inital wp_umunandi database image
   * Runs composer install

1. The umunandi.test dev site is now up and running 🙂 but it's empty 😕. Next step is to need to grab the latest content and configuration by downloading the DB and media files from the staging site (staging.umunandi.org).
   * Go to [MigrateDB](https://umunandi.test/wp/wp-admin/tools.php?page=wp-sync-db&wpsdb-profile=1) in the dev site WordPress admin pages (user: dev, pass: dev)
   * Enter the staging site connection url (get this from the Umunandi web admin (me))
   * Wait for the connection to be established
   * Make sure the the 'Media files' option is ticked
   * Click the *[Migrate DB & Save]* button
   * Leave it to chug through downloading the staging site content
   * You should now have an up to date dev site 👍🏼

The Umunandi site is built as a WordPress theme based on [Roots](https://roots.io/). Roots uses *grunt* to build js and less/css assets. To install and run grunt:

```
$ cd ./umunandi.org/web/app/themes/umunandi
$ npm install   // installs grunt
$ grunt watch   // watch task dynamically recompiles less and js assets
```

## Updating WordPress / plugins
[Roots uses Composer](https://roots.io/using-composer-with-wordpress/) to manage dependencies such as WordPress plugins, and indeed WordPress itself. To update WordPress and/or plugins **don't** use the WordPress admin UI update links. Instead:

1. Backup the database from the WordPress admin UI (okay, I know I said don't use the admin UI, but we use it for backing up the DB okay?): *Settings > Migrate DB > Migrate > Local backup*.
1. Edit *composer.json* and update the relevant version numbers for the dependencies you want to update.
2. Log in to vvv  
`$ cd vvv`  
`$ vagrant ssh`  
`$ cd umunandi.test`
3. Run `composer update --dry-run` to show what packages will be updated without actually doing anything.
1. To update WordPress run `$ composer update johnpbloch/wordpress*`
1. Test <http://umunandi.test> is still working
1. To update plugins run `$ composer update wpackagist*`, or specify the name of the individual plugin(s) you want to update.
1. Test <http://umunandi.test> is still working
2. Other useful composer commands:  
`$ composer list` - lists composer commands (kinda like --help)  
`$ composer info` - lists all the installed packages  
`$ composer require packagename` - Adds a package to composer.json and installs it  
`$ composer remove packagename` - Removes a package from composer.json and uninstalls it



## Managed deployment

The production server hosts two environments, __production__ and __staging__. Deployment to the server is done [using git](http://toroid.org/ams/git-website-howto) for the code and [wp-sync-db plugin](https://github.com/wp-sync-db/wp-sync-db) for the database. Connect to the server using [ssh keys](http://smbjorklund.no/ssh-login-without-password-using-os-x) - this works for both terminal sessions and git.

In addition to the steps below, the server also needs to have databases and subdomains set up. This is configured using the normal cPanel admin UI. You can use phpMyAdmin to copy databases if necessary - useful when creating new environments for the first time.

Everything on the server lives in _~/umunandi.org_:

```
/~
├ umunandi.org
  ├ production         <= main web site
  ├ staging            <= staging site
  ├ umunandi.org.git   <= bare repositry
  └ v1                 <= old site
```

### Setup

* Create the directory structure above.  

* Create the [bare repositry](http://www.saintsjd.com/2011/01/what-is-a-bare-git-repository/):  
`$ cd umunandi.org.git && git init --bare`

* In your dev environment, set the bare repo as a new remote (the _umunandi:_ protocol is enabled by using [ssh config](http://osxdaily.com/2011/04/05/setup-ssh-config-fie/))  
`$ git remote add production umunandi:umunandi.org/umunandi.org.git` 

* Push the staging branch:  
`$ git push production staging` 

* At this point the repo should now be on the server, but the _staging_ directory is still empty as the git-hook that populates it is not in place on the server. To make the git-hook available, we copy the post-receive script from the repo to _umunandi.org.git/hooks_ using _git archive_:  
`$ git archive staging deploy/post-receive | tar -x --strip-components=1 -C hooks/` 

* Now push the staging branch from _dev_ again and the git-hook will checkout the repo into the _staging_ directory.  
`$ git push production staging`

The staging directory should now look like this:

```
└ staging
  ├ config
  | └ environments   <= contains .env files
  ├ deploy           <= contains post-receive git hook
  ├ vendor           <= composer libraries
  ├ vvv-setup        <= ignored on server
  └ web              <= configured as staging site web-root in cPanel
    ├ app
    ├ stuff
    └ wp
```

* Create the environment specific .env file. In _config/environments_ copy _.env.dev_ to _.env_ and then edit the new _.env_ file, setting the appropriate DB connection details, etc. 

* Add a new _.htaccess_ file to _~/umunandi.org/staging/web/_. The contents of this are file very environment specific so it's not included in the git repo. Maybe it should be...? Perhaps put a copy in _/config/environments/_?

### Deployment steps

There's a challenge here in terms of data management. Site content updates are made on the **live** site - new posts, etc. Site development updates are made on the **dev** site - new plugins, functionality etc. Both types of changes affect the database. When deploying new changes from dev => live how do we push the new dev DB changes to the live DB without overriding any content changes that have happened on live?

The ideal solution would be for dev DB changes to be scripted and the SQL scripts to be replayed on the live DB, thereby injecting the new DB content/structure without disrupting the existing content.

For now, the only approach is to sync down the DB from live => dev on a regular basis and especially prior to doing a code update. I'm *preeeety* sure this is going to bite me in the ass at some point, but I guess I'll have to deal with that when it happens.


