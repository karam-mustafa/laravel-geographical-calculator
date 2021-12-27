Get closest point
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
Get ordering points by nearest neighbor algorithm
---------------
This algorithm can be explained as preparing the main point and searching for the closest point to it, then placing it in the second order,
then the algorithm re-searching for the point closest to the second point and placing it in the third order, and so on...
```php
     $getOrderByNearestNeighbor  = \KMLaravel\GeographicalCalculator\Facade\GeoFacade::setMainPoint([22, 37])
            ->setPoints([
                [33, 45],
                [31, 40],
            ])
            ->getOrderByNearestNeighbor();
     //  the result will be array of points that you inserted before, and this points are ordered as we explain above.
     return $getOrderByNearestNeighbor;
```
