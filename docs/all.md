All features in one function:
----------
For now, only center and distance supported in this function.
```php
    // Define your points
    $allFeature =  \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoint([22, 37])
            // add your options, the default value for the unit is mile.
            ->setOptions(['units' => ['km']])

            // you can set unlimited points.
            // ->setPoint([lat, long])
            // ->setPoint([lat, long])
            ->setPoint([33, 40])
            ->allFeatures();
    // the result will be array contains ['distance' => '...' , 'center' => '...']
    // each output was described in docs files.
    return $allFeature;
```
