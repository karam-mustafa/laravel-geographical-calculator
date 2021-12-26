<?php

namespace KMLaravel\GeographicalCalculator\Traits;

trait Areas
{
    /**
     * get the center from a given data.
     *
     * @param  null|callable  $callback
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
        if (! $this->getFromStorage('pointsCount')) {
            return false;
        }

        // reset all dimensions values.
        $this->resetDimensions();

        // loop through each point and add the lat and long to each dimension.
        $this->through($this->getPoints(), function ($index, $point) {
            // set lat and long
            $this->setInStorage('lat', $point[0] * pi() / 180);
            $this->setInStorage('long', $point[1] * pi() / 180);
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
                'lat' => $this->getFromStorage('lat') * 180 / pi(),
                'long' => $this->getFromStorage('long') * 180 / pi(),
            ]);

        return isset($callback)
            ? collect($callback($this->getResult()))
            : $this->getResult();
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
