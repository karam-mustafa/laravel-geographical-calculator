All features in one function:
----------
```php
    // Define your points
    $all =  \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoint([22, 37])
            // add your options, the default value for the unit is mile.
            ->setOptions(['units' => ['km']])

            // you can set unlimited points.
            // ->setPoint([lat, long])
            // ->setPoint([lat, long])
            ->setPoint([33, 40])
            ->allFeature();
    // the result will be array contains ['distance' => 'the distances output' , 'center' => 'the center output']
    // each output was described in docs files.
    return $all;
```
