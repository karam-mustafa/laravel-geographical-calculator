## Geographical Calculator
[![License](https://poser.pugx.org/kmlaravel/apis-generator/license)](//packagist.org/packages/kmlaravel/apis-generator)
[![Build Status](https://scrutinizer-ci.com/g/kmlaravel/apis-generator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/kmlaravel/apis-generator/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/kmlaravel/apis-generator/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Code Quality](https://www.code-inspector.com/project/16475/score/svg)](https://www.code-inspector.com/project/16475/score/svg)

Geographical Calculator was developed for laravel 5.8+ to facilitate future geographical searches this package is implemented for now a simple distance calculation between two geographical points

Installation
------------
##### 1 - Dependency
The first step is using composer to install the package and automatically update your composer.json file, you can do this by running:

```shell
composer require kmlaravel/laravel-geographical-calculator
```
> ###### Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.
##### 2-1 - Copy the package providers to your local config with the publish command, this will publish asset and config :
```shell
php artisan vendor:publish --provider="KMLaravel\GeographicalCalculator\Providers\GeographicalCalculatorServiceProviders"
```
##### 2-2 - Or you may Copy the package config to your local config with the publish command:
```shell
php artisan vendor:publish --tag=geographical-calculator-config
```

Basic usage
-----------
##### basic example
```php
    // define your values
    // $class = \KMLaravel\GeographicalCalculator\Facade\GeographicalCalculatorFacade::initCoordinates($firstLat , $secondLat , $firstLon , $secondLon , ['units' => ['km']]);
    $class = \KMLaravel\GeographicalCalculator\Facade\GeographicalCalculatorFacade::initCoordinates(22,33,37,40 , ['units' => ['km']]);
    return $class->getDistance();
    // the result is array contains values based on your units options insertion [ "km" => 1258.1691302282 ] 
```


config options
----------------
> ## add your custom units
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
