
# Laravel 5 Starter

> just another laravel app starter

Fully inspired by [octobercms](http://octobercms.com)

#### Feature
* User Authentication
* User Management and Role Management
* Dynamic User Permissions
* Dynamic Role Permissions
* Restricted access page
* Dynamic Menu Builder
* Dynamic Permission register
* Email Setting
    * Mandrill
    * Mailgun
    * PHP Mail
    * Sendmail
    * Log

#### Instalation
Download the repository or clone https://github.com/ardiansyah/laravel-starter.git

create database

rename .env.example to .env and update username, and password for database

then run

```
composer install

php artisan migrate

php artisan db::seed
```

by default authentication will be:

email: admin@admin.com

password: admin

#### Tools
1. [Cartalys Sentinel](https://cartalyst.com/manual/sentinel/2.0)
2. [Laracast Flash](https://github.com/laracasts/flash)
3. [Setter](https://github.com/bradcornford/Setter)
4. [Watson validation](https://github.com/dwightwatson/validating)
5. [Dry UI](https://github.com/daftspunk/dry-ui/)
6. [SB Admin Bootstrap](http://startbootstrap.com/template-overviews/sb-admin-2/)
