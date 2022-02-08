Get the center for a given coordinates
-------
```php
    // Define your points
    $center =  \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoint([22, 37])
            // you can set unlimited points.
            // ->setPoint([lat, long])
            // ->setPoint([lat, long])
            ->setPoint([33, 40])

            // get the calculated center between these points.
            ->getCenter();
            // the result should be array contains lat value and long value
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
            // the result should be array contains lat value and long value

     return $center;
```
Check if a given point located in a given area
---------------
```php

    $isInArea = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setMainPoint([22, 37])
            // diameter in kilo meter
             ->setDiameter(1000)
            // point to check, do not insert more than one point here.
             ->setPoint([33, 40])
             ->isInArea();
             // the result is true or false
         return $result;
```
Callback functions
---------------
```php
     // You can see that sometimes it can be confusing to deal with the output,
     // so you can use callback in the getDistance function.// 
     $center  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoints([
                [22, 37],
                [33, 40],
                // .... other points
            ])
            // and of course, you still can use getPoint again if you want.
            ->setPoint([33, 40])
            ->getCenter(function(\Illuminate\Support\Collection $result){
                // you can do what you want on the result.
                return $result->first();
            });
            // the result should be array contains lat value and long value

     return $center;
```
Use Multiple execution
---------------
This package use the registry pattern and storage state to save all results,
so if you want to use the geo class instance multiple time you should clear the previous results,
and you can do that by calling `clearResult()` function.
```php
     $exec1  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setPoints([
                [22, 37],
                [33, 40],
            ])
            ->getCenter(function(\Illuminate\Support\Collection $result){
                return $result->first();
            });
    $exec2  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::clearResult()->setPoints([
                [22, 37],
                [33, 40],
            ])
            ->getCenter(function(\Illuminate\Support\Collection $result){
                return $result->first();
            });
    dd($exec1,$exec2);
```


