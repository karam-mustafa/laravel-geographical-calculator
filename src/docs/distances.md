##### Get the distance between unlimited points:
```php
    // Define your values
    $distance =  \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoint([22, 37])
            // add your options, the default value for the unit is mile.

            ->setOptions(['units' => ['km']])

            // you can set unlimited points.
            // ->setPoint([lat, long])
            // ->setPoint([lat, long])

            ->setPoint([33, 40])

            // get the calculated distance.
            // lets suppose you added 6 points
            // this package will return the distance between a first and a second point.
            // a second and a third point.
            // a third and a fourth point and so on.
            // each result will returned  with the index of each point
            // for example, the first and second point you add will shown like this
            // "1-2" => ["km" => 1258.1691302282]

            ->getDistance();
    // The result is array contains values based on your units options insertion [ "km" => 1258.1691302282 ] 

    // If you set multiline units, the result will be each unit with the distance.
     $distanceWithMultiUnits  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoint([22, 37])
            ->setPoint([33, 40])
            // Set your units you want.
            ->setOptions(['units' => ['km' , 'mile' , 'm' , 'cm']])
            ->getDistance();
    // the result will be [  "km" => 1258.1691302282, "mile" => 781.79005248609, "m" => 1258169.1302282, "cm" => 125816.91302282]
    

    return $distance;
```
