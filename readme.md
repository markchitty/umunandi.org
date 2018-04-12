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


## Managed deployment

The production server hosts two environments, __production__ and __staging__. Deployment to the server is done [using git](http://toroid.org/ams/git-website-howto) for the code and [wp-sync-db plugin](https://github.com/wp-sync-db/wp-sync-db) for the database. Connect to the server using [ssh keys](http://smbjorklund.no/ssh-login-without-password-using-os-x) - this works for both terminal sessions and git.

In addition to the steps below, the server also needs to have databases and subdomains set up. This is configured using the normal cPanel admin UI.

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

1. Create the directory structure above.  

1. Create the [bare repositry](http://www.saintsjd.com/2011/01/what-is-a-bare-git-repository/):  
`$ cd umunandi.org.git && git init --bare`

1. In your dev environment, set the bare repo as a new remote (the _umunandi:_ protocol is enabled by using [ssh config](http://osxdaily.com/2011/04/05/setup-ssh-config-fie/))  
`$ git remote add production umunandi:umunandi.org/umunandi.org.git` 

1. Push the staging branch:  
`$ git push production staging` 

1. At this point the repo should now be on the server, but the _production_ and _staging_ directories are still empty as the git-hook that populates them is not in place on the server. To make the git-hook available, we copy the post-receive  script from the repo to _umunandi.org.git/hooks_ using _git archive_:  
`$ git archive staging deploy/post-receive | tar -x --strip-components=1 -C hooks/` 

1. Now push the staging branch from _dev_ again and the git-hook will checkout the repo into the _staging_ directory. To update the production site simply push the master branch instead:  
`$ git push production master` 


```
production         <= staging has the same structure
├ config
├ deploy           <= contains post-receive git hook 
├ vvv-setup        <= ignored on server
└ web              <= web-root - symlink'd to ~/public_html
  ├ app
  ├ stuff
  └ wp
```

### Deployment steps

There's a challenge here in terms of data management. Site content updates are made on the **live** site - new posts, etc. Site development updates are made on the **dev** site - new plugins, functionality etc. Both types of changes affect the database. When deploying new changes from dev => live how do we push the new dev DB changes to the live DB without overriding any content changes that have happened on live?

The ideal solution would be for dev DB changes to be scripted and the SQL scripts to be replayed on the live DB, thereby injecting the new DB content/structure without disrupting the existing content.

For now, the only approach is to sync down the DB from live => dev on a regular basis and especially prior to doing a code update. I'm *preeeety* sure this is going to bite me in the ass at some point, but I guess I'll have to deal with that when it happens.


