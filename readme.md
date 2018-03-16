# umunandi.org website

umunandi.org is the website for **Umunandi**, a UK based charity supporting orphans and vulnerable children in Zambia.

The website is built on WordPress, running

+ WordPress-Skeleton <https://github.com/markjaquith/WordPress-Skeleton> - copied not cloned (don't want the history). Uses WordPress as a submodule.
+ Roots theme <http://roots.io> & <https://github.com/roots/roots>. Theme renamed to Umunandi.

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
`$ mkdir umunandi; $ cd umunandi`

1. **Get umunandi.org** - Clone this repo into */umunandi.org*  
`$ git clone git://github.com/umunandi/umunandi.org umunandi.org`

1. **Get VVV** - Clone Varying Vagrant Vagrants into */vvv* and checkout v1.4.1  
`$ git clone git://github.com/Varying-Vagrant-Vagrants/VVV.git vvv`  
`$ cd vvv`  
`$ git checkout tags/1.4.1 -b 1.4.1`

1. **Configure dev env** - Run the config script to configure the umunandi.test web-site in VVV  
`$ ../umunandi.org/vvv-setup/umunandi.config.sh`

1. **Provision dev machine** - Downloads the VM image and configures it (may take a few mins)  
`$ vagrant up`  
The vagrant provisioning script will ask you for your password so that it can update your hosts file with local DNS entries for *umunandi.test*. 

1. Point your browser to <http://umunandi.test> to browse the website. The WordPress admin page is available at <http://umunandi.test/wp-admin>.
2. The Umunandi site is built as a WordPress theme based on [Roots](https://roots.io/). Roots uses grunt to build js and less. To install and run grunt:

```
$ cd ./umunandi.org/web-root/content/themes/umunandi
$ npm install   // installs grunt
$ grunt watch   // watch task dynamically recompiles less and js assets
```

<sup>* To read more about vagrant and what it can do, run `vagrant` from the vvv directory</sup>

## Updating WordPress
WordPress-Skeleton references the WordPress codebase as a git submodule. To update WordPress **don't** use the built-in admin Update feature. Instead, use git to update the submodule to the latest version tag - useful instructions [here](http://ryansechrest.com/2014/04/update-deploy-wordpress-git-submodule/) and [here](https://blog.sourcetreeapp.com/2012/02/01/using-submodules-and-subrepositories/). **Note:** back up the DB first.

```
$ cd umunandi.org/web-root/wp
$ git fetch --tags

From https://github.com/WordPress/WordPress
 * [new tag]         3.7.2      -> 3.7.2
 * [new tag]         3.8.2      -> 3.8.2

$ git checkout 3.8.2
```

This will show up in the umunandi.org (parent) repo as an uncomitted change to the submodule's tracked commit. Commit this change.

Finally, log in to the local WordPress admin pages and click the Update DB button that you should be redirected to. Hopefully everything won't blow up at this point.

## Managed deployment configuration

The production server at umunandi.org is set as a git remote for pushing to.

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
