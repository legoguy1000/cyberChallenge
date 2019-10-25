# cyberChallenge


# Prerequisites
* Apache Web Server
  * Mod Rewrite enabled
  * libapache2-mod-php
* PHP 7.2 or greater (7.3 is currently the latest)
  * php 
  * libapache2-mod-php 
  * php-mysql
  * php-mbstring 
  * php-xml 
* Composer [install instructions](https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md)
* MySQL
* Git

# Install

Clone Git Repo
```
git clone https://github.com/legoguy1000/cyberChallenge.git
```
Run initalInstall.php script located in (/api/app/) and input the requested information
```
cd api/app
composer install
composer dump-autoload
php _CreateDatabase.php
php _PopulateDatabase.php
```
Go to https://realfavicongenerator.net/ and generate your favicons.  place files in /favicons/.
