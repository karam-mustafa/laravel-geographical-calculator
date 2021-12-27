![logo](assets/logo.png)


## Geographical Calculator
[![License](https://poser.pugx.org/kmlaravel/apis-generator/license)](//packagist.org/packages/kmlaravel/laravel-geographical-calculator)
[![PHP Composer](https://github.com/karam-mustafa/laravel-geographical-calculator/actions/workflows/php.yml/badge.svg)](https://github.com/karam-mustafa/laravel-geographical-calculator/actions/workflows/php.yml)
[![Check & fix styling](https://github.com/karam-mustafa/laravel-geographical-calculator/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/karam-mustafa/laravel-geographical-calculator/actions/workflows/php-cs-fixer.yml)
[![Run tests](https://github.com/karam-mustafa/laravel-geographical-calculator/actions/workflows/tests.yml/badge.svg)](https://github.com/karam-mustafa/laravel-geographical-calculator/actions/workflows/tests.yml)
[![Code Quality](https://api.codiga.io/project/30429/score/svg)](https://api.codiga.io/project/30429/score/svg)

Geographical Calculator was developed for laravel 5.8+ to help you to implement geographical calculation, 
with With several algorithms that help you deal with coordinates.

Installation
------------
##### 1 - Dependency
The first step is using composer to install the package and automatically update your composer.json file, you can do this by running:

```shell
composer require kmlaravel/laravel-geographical-calculator
```
##### 2 - Copy the package providers to your local config with the publish command, this will publish the config:
```shell
php artisan geo:install
```

Features
-----------
- [Get the distance between one or more of points](https://github.com/karam-mustafa/laravel-geographical-calculator/blob/main/docs/distances.md#basic-usage)
- [Get the center between set of points](https://github.com/karam-mustafa/laravel-geographical-calculator/blob/main/docs/areas.md#get-the-center-for-a-given-coordinates)
- [Get the closest point to the specific point](https://github.com/karam-mustafa/laravel-geographical-calculator/blob/main/docs/ordering.md#get-closest-point)
- [Get a ranking of points by the nearest neighbor algorithm](https://github.com/karam-mustafa/laravel-geographical-calculator/blob/main/docs/ordering.md#get-ordering-points-by-nearest-neighbor-algorithm)
- [Get all package features](https://github.com/karam-mustafa/laravel-geographical-calculator/blob/main/docs/all.md#all-features-in-one-function)


config options
----------------
> ## add your custom units,keys ..etc.
>
```php
    /*
    |--------------------------------------------------------------------------
    | units values
    |--------------------------------------------------------------------------
    | your custom units, the initial units its convert from a mile to any value
    | (1.609344) is the conversion factor from a mile to a kilometer
    */
    'units' => [
        'mile' => 1,
        'km' => 1.609344,
        'm' => (1.609344 * 1000),
        'cm' => (1.609344 * 100),
        'mm' => (1.609344 * 1000 * 1000),
    ],

    /*
    |--------------------------------------------------------------------------
    | distance_key_prefix
    |--------------------------------------------------------------------------
    | if you declared more than tow points to resolve their distance,
    | you will see the result in the following format:
    | "1-2" => ["km" => "some result"],
    | "2-3" => ["km" => "some result"],
    | "3-4" => ["km" => "some result"],
    | and if you want to set any prefix before each index
    | you must change the below value to any value you want.
    |
    */
    'distance_key_prefix' => '',
```

Changelog
---------
Please see the [CHANGELOG](https://github.com/kmlaravel/laravel-geographical-calculator/blob/master/CHANGELOG.md) for more information about what has changed or updated or added recently.

Security
--------
If you discover any security related issues, please email them first to karam2mustafa@gmail.com, 
if we do not fix it within a short period of time please open a new issue describing your problem. 

Credits
-------
[karam mustafa](https://www.linkedin.com/in/karam2mustafa)
