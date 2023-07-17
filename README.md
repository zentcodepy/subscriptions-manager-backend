# Subscriptions Manager Backend

### Description
* The purpose of this program is to provide a subscription manager backend system.

### Installation
* Clone this repository
* Create .env file with DB variables: DB_DATABASE, DB_USERNAME and DB_PASSWORD (don't use root for DB_USERNAME)
* From project directory execute: ```docker-compose build app```
* From project directory execute: ```docker-compose up -d```
* From project directory execute: ```docker exec <container-name> composer install```

### Built With
* [Laravel](https://laravel.com/)
* [PHP](https://www.php.net/) - v8.1

### Static Analysis
* PHPUnit is used to test the code. In order run tests, type: ```php artisan test```

### Static Analysis
* PHPStan is used to make static analysis. In order to analyse the project, type: ```./vendor/bin/phpstan analyse```

### IDE Helper
* After adding a new Model, or after adding columns or relationships to an exisiting one, run: ```php artisan ide-helper:models -M```

<p align="right">(<a href="#top">back to top</a>)</p>

### License
This project and the Laravel framework are open-sourced software licensed under the [MIT](https://opensource.org/licenses/MIT).
