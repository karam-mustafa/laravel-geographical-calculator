Closest Point
---------------
```php
     $closest  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setMainPoint([22, 37])
            ->setPoints([
                [22, 37],
                [33, 40],
                // .... other points
            ])
            // and of course, you still can use getPoint again if you want.
            ->setPoint([33, 40])
            // you can use callback, the callback is return Collection instance of result.
            ->getClosest();

     //  the result will be array of [pointIndex => [lat , long]] that you inserted before.
     return $closest;
```
