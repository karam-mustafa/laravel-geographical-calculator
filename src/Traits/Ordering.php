<?php

namespace KMLaravel\GeographicalCalculator\Traits;

trait Ordering
{
    /**
     * @author karam mustafa
     *
     * @var array
     */
    private $pointsAppendedBefore = [];

    /**
     * get the closest point to the main point.
     *
     * @param  null|callable  $callback
     *
     * @return mixed
     * @author karam mustafa
     */
    public function getClosest($callback = null)
    {
        $this->resolveEachDistanceToMainPoint();

        // set the closest point index after we sort the distances result.
        $this->setInStorage(
            'closestPointIndex',
            collect($this->getFromStorage('distancesEachPointToMainPoint'))->sort()->keys()->first()
        );

        $this->setResult([
            "closest" => [
                $this->getFromStorage('closestPointIndex') => $this->getFromStorage('points')[$this->getFromStorage('closestPointIndex')],
            ],
        ]);

        return $this->resolveCallbackResult($this->getResultByKey('closest'), $callback);
    }

    /**
     * get the farthest point to the main point.
     *
     * @param  null|callable  $callback
     *
     * @return mixed
     * @author karam mustafa
     */
    public function getFarthest($callback = null)
    {
        $this->resolveEachDistanceToMainPoint();

        // set the closest point index after we sort the distances result.
        $this->setInStorage(
            'farthestPointIndex',
            collect($this->getFromStorage('distancesEachPointToMainPoint'))->sortDesc()->keys()->first()
        );

        $this->setResult([
            "farthest" => [
                $this->getFromStorage('farthestPointIndex') => $this->getFromStorage('points')[$this->getFromStorage('farthestPointIndex')],
            ],
        ]);

        return $this->resolveCallbackResult($this->getResultByKey('farthest'), $callback);
    }

    /**
     * Add the key to each point, and use the Nearest Neighbor Algorithm to resolve the order of the data.
     *
     * @return mixed
     * @author karam mustafa
     */
    public function getOrderByNearestNeighbor()
    {
        // get each point and update it to add a key.
        $this->resolveKeyForEachPoint();

        // append main point as a first point in points array.
        $this->replacePoints(array_merge([
            [$this->getMainPoint()[0], $this->getMainPoint()[1], 'key' => 0],
        ], $this->getPoints()));

        return $this->nearestNeighborAlgorithm($this->getPoints());
    }

    /**
     * get the closest point to the main point.
     *
     * @param $points
     * @param  array  $result
     * @param  int  $sizeOfPoints
     * @param  string  $key
     *
     * @return mixed
     * @author karam mustafa
     */
    public function nearestNeighborAlgorithm($points, $result = [], $sizeOfPoints = 0, $key = 'key')
    {
        $res = $result;

        // if the res variable have a zero size,
        // this mean we are now in the main point,
        // so we will append the first point in the res array.
        if (sizeof($res) == 0) {
            $res[0] = collect($points)->first();

            // push this key to the keys were we visited before.
            array_push($this->pointsAppendedBefore, 0);
        }

        // If all points were visited,
        // we return the final result.
        if (sizeof($res) == $sizeOfPoints) {
            return $res;
        }

        // if there are not points we return the array
        // that contains only the main points with distance 0.
        if (sizeof($points) == 0) {
            return $res;
        }

        // We will compare the values with the diameter of the Earth,
        // because no distance can be greater than this number.
        $distance = 64800 * 2;

        // The point closest to the last point in the array of variable res,
        // among the other set of points
        $pointKeyToPush = '';

        // get the last point.
        $lastPoint = $res[array_key_last($res)];

        // now we will go through each point,
        // and we will calculate the current point with the last point,
        // and get the closest point into the last point in res array.
        // if it find any point we keep looking at all the points until we reach the closest point.
        foreach ($points as $pointKey => $point) {

            // clear all stored results and point
            // that keep us able to keep the result is clean
            $this->clearResult();

            // check if we dont calculate the point distance with itself.
            if ($point[$key] == $lastPoint[$key]) {
                continue;
            }

            // calculate the last point that we want to find the closest point to it
            // with the current point iteration.
            $distanceCalc = $this->setPoints([
                [$lastPoint[0], $lastPoint[1]],
                [$point[0], $point[1]],
            ])->setOptions(['units' => ['km']])->getDistance(function ($point) {
                return $point->first()['km'];
            });

            // if the calculation result is lower than the last distance value
            // this mean we are finding now point that closest than the previous results.
            if ($distanceCalc < $distance) {
                $distance = $distanceCalc;

                $pointKeyToPush = $points[$pointKey][$key];
            }
        }

        // if we have only one point,
        // then we push this point.
        if (sizeof($points) == 1) {
            $pointKeyToPush = collect($points)->first()[$key];
        }

        // Now we append this point to the result array.
        $res[$pointKeyToPush] = $points[collect($points)->where($key, $pointKeyToPush)->keys()[0]];

        // and mark this point as a visited point
        array_push($this->pointsAppendedBefore, $pointKeyToPush);

        // assign the calculated distance to it.
        // $res[$pointKeyToPush]['distance'] = $distance;

        // Get the new points array without the visited points.
        $points = collect($points)->whereNotIn($key, $this->pointsAppendedBefore);

        // re call the previous implementation, until we visit all points.
        return $this->nearestNeighborAlgorithm($points, $res, $sizeOfPoints, $key);
    }

    /**
     * this function will go through each point, and add the key to it.
     *
     * @return  void
     * @author karam mustafa
     */
    private function resolveKeyForEachPoint()
    {
        foreach ($this->getPoints() as $index => $point) {
            $this->updatePoint($index, function ($p) use ($index) {
                return [$p[0], $p[1], 'key' => $index + 1];
            });
        }
    }
}
