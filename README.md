# Cyber Challenge


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
* Composer [install instructions](https://getcomposer.org/download/)
* MySQL
* Git

# Install

Install PHP with required prerequisites
```
Ubuntu: apt-get install php libapache2-mod-php php-mysql php-mbstring php-xml (optionally install php7.2-opcache/php7.3-opcache)
CentOS: yum install php libapache2-mod-php php-mysql php-mbstring php-xml (optionally install php7.2-opcache/php7.3-opcache)
```

Install Composer  
Follow the instructions from [install instructions](https://getcomposer.org/download/).  Then move the composer.phar file from the current directory to make it globally accesible.
```
mv composer.phar /usr/local/bin/composer
```

Clone Git Repo into your web dir
```
ex. cd /var/www/html
git clone https://github.com/legoguy1000/cyberChallenge.git .
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
If you made composer global run
```
composer install
composer dump-autoload
```
Otherwise run
```
/path/to/composer.phar install
/path/to/composer.phar dump-autoload
```

Run the PHP files to create the DB and seed with initial questions
```
php _CreateDatabase.php
php _PopulateDatabase.php
```
Go to https://realfavicongenerator.net/ and generate your favicons.  Do not copy the HTML (that already exists). Place files in /favicons/.
