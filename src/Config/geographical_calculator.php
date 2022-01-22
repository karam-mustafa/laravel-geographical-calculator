<?php

return [

    /*
    |--------------------------------------------------------------------------
    | units values
    |--------------------------------------------------------------------------
    | your custom units, the initial units its convert from mile to any value.
    |
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
];
