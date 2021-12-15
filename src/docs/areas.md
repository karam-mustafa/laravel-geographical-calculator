##### Get the center for a given coordinates
```php
    // Define your points
    $center =  \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoint([22, 37])
            // you can set unlimited points.
            // ->setPoint([lat, long])
            // ->setPoint([lat, long])
            ->setPoint([33, 40])

            // get the calculated center between these points.
            ->getCenter();

    return $center;
```
All points at once
---------------
```php
    // instead of calling setPoint each time
    // you can set your points at once.
     $center  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoints([
                [22, 37],
                [33, 40],
                // .... other points
            ])
            // and of course, you still can use getPoint again if you want.
            ->setPoint([33, 40])
            ->getCenter();

     return $center;
```
