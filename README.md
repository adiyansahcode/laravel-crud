<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="250">
    </a>
</p>

# Laravel-Crud
simple CRUD project created with laravel v7

## Requirements

| no | name | version |
| ------------- | ------------- | ------------- |
| 1 | nginx | * |
| 2 | php | >= 7.3 |
| 3 | laravel | 7 |
| 4 | mariaDB | >= 10 |

## Installation

* clone this project
```
git clone https://github.com/adiyansahcode/laravel-crud.git
```

* create .env file

* clean cache, create key and create storage for images
```
php artisan optimize:clear
php artisan key:generate
php artisan storage:link
```

* run composer
```
composer install
```

* run Migration and Seeder
```
php artisan migrate:fresh --seed
```

* run server
```
php artisan serve --port=8080
```

* done, just try run your project in browser to http://localhost:8080

## Task List

* [x] Book CRUD
* [x] Laravel Migrate and Seeder
* [x] Laravel Validation
* [x] Laravel Html
* [x] Template with AdminLte v3 ([jeroennoten](https://github.com/jeroennoten/Laravel-AdminLTE))
* [x] View Table with DataTables ([yajra](https://github.com/yajra/laravel-datatables))
