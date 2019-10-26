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

Go into the app directory
```
cd api/app
```
Make a copy of the ini file and rename to config.ini and edit the config.ini with you DB information
```
mv config.example.ini config.ini
```
Run Composer to install the dependencies
```
composer install
composer dump-autoload
```
Run the PHP files to create the DB and seed with initial questions
```
php _CreateDatabase.php
php _PopulateDatabase.php
```
Go to https://realfavicongenerator.net/ and generate your favicons.  Place files in /favicons/.
