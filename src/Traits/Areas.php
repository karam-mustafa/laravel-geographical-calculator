<?php

namespace KMLaravel\GeographicalCalculator\Traits;

use Illuminate\Support\Collection;

trait Areas
{
    /**
     * get the center from a given data.
     *
     * @param null|callable $callback
     *
     * @return array|bool|\Illuminate\Support\Collection
     *
     * @author karam mustafa
     */
    public function getCenter($callback = null)
    {

        // set points count in the storage.
        $this->setInStorage('pointsCount', count($this->getPoints()));

        // check if there are points or not.
        if (!$this->getFromStorage('pointsCount')) {
            return false;
        }

        // reset all dimensions values.
        $this->resetDimensions();
        // loop through each point and add the lat and long to each dimension.
        $this->through($this->getPoints(), function ($index, $point) {
            // set lat and long
            $this->setInStorage('lat', ($point[0] * pi() / 180));
            $this->setInStorage('long', ($point[1] * pi() / 180));
            // set dimensions
            $this->setInStorage(
                'x',
                (
                    $this->getFromStorage('x') +
                    cos($this->getFromStorage('lat')) * cos($this->getFromStorage('long'))
                )
            )->setInStorage(
                'y',
                (
                    $this->getFromStorage('y') +
                    cos($this->getFromStorage('lat')) * sin($this->getFromStorage('long'))
                )
            )->setInStorage(
                'z',
                (
                    $this->getFromStorage('z') +
                    sin($this->getFromStorage('lat'))
                )
            );
        });

        // divide each dimension to all point count.
        $this->resolveDimensionByPointsCount()
            // set final lat and long
            ->resolveCoordinates()
            // register this lat and long in results,
            // so we can access this result from any next execution,
            // if we have multi process or tasks in future.
            ->setResult([
                'lat'  => $this->getFromStorage('lat') * 180 / pi(),
                'long' => $this->getFromStorage('long') * 180 / pi(),
            ]);

        return isset($callback)
            ? collect($callback($this->getResult()))
            : $this->getResult();
    }

    /**
     * check if the point is in area that created depending on the main point and the diameter.
     *
     * @return true
     *
     * @author karam mustafa
     */
    public function isInArea()
    {
        // store the points in different
        $this->setInStorage('mainPointToCheck', $this->getMainPoint());
        $this->setInStorage('pointToCalculateArea', $this->getPoints()[0]);
        // clear the points and reset them
        $this->clearPoints();
        $this->setPoints([$this->getFromStorage('mainPointToCheck'), $this->getFromStorage('pointToCalculateArea')]);

        // now this is the hard part, we must calculate the distance
        // between the main point and the point that you want to check it.

        // if the distance between these points is bigger than the given diameter
        // then this mean the point is not within the area

        // otherwise mean that the distance between the given point is locate in the circle that calculated
        // from the main point and the diameter
        $this->setInStorage(
            'distanceToCompare',
            $this->setOptions(['units' => ['km']])->getDistance(function (Collection $item) {
                return $item->first()['km'];
            })
        );

        return $this->getFromStorage('distanceToCompare') > $this->getDiameter();
    }

    /**
     * reset all dimension values.
     *
     * @return Areas
     *
     * @author karam mustafa
     */
    public function resetDimensions()
    {
        $this->setInStorage('x', 0.0)
            ->setInStorage('y', 0.0)
            ->setInStorage('z', 0.0)
            ->setInStorage('dimensions', ['x', 'y', 'z']);

        return $this;
    }

    /**
     * get dimensions and loop for each one
     * divide dimension value by points count.
     *
     * @return Areas
     *
     * @author karam mustafa
     */
    private function resolveDimensionByPointsCount()
    {
        $this->through($this->getFromStorage('dimensions'), function ($index, $dimension) {
            $this->setInStorage(
                $dimension,
                ($this->getFromStorage($dimension) / $this->getFromStorage('pointsCount'))
            );
        });

        return $this;
    }

    /**
     * set final lat and long values.
     *
     * @return Areas
     *
     * @author karam mustafa
     */
    private function resolveCoordinates()
    {
        $this->setInStorage('long', atan2(
            $this->getFromStorage('y'),
            $this->getFromStorage('x')
        ))->setInStorage(
            'multiplied y',
            ($this->getFromStorage('y') * $this->getFromStorage('y'))
        )->setInStorage(
            'multiplied x',
            ($this->getFromStorage('x') * $this->getFromStorage('x'))
        )->setInStorage(
            'distance',
            sqrt($this->getFromStorage('multiplied x') + $this->getFromStorage('multiplied y'))
        )->setInStorage('lat', atan2($this->getFromStorage('z'), $this->getFromStorage('distance')));

        return $this;
    }
}
