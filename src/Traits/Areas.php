<?php


namespace KMLaravel\GeographicalCalculator\Traits;


trait Areas
{
    /**
     * description
     *
     * @return bool
     * @author karam mustafa
     */
    public function getCenter()
    {

        // set points count in the storage.
        $this->setInStorage('pointsCount', count($this->getPoints()));
        // check if there are points or not.
        if (!$this->getFromStorage('pointsCount')) {
            return false;
        }

        // reset all dimensions values.
        $this->resetDimensions();

        // loop throughout each point and add the lat and long to each dimension.
        foreach ($this->getPoints() as $point) {
            // set lat and long
            $this->setInStorage('lat', $point[0] * pi() / 180);
            $this->setInStorage('lon', $point[0] * pi() / 180);
            // set x,y,z
            $this->setInStorage('x',
                (
                    $this->getFromStorage('x') +
                    cos($this->getFromStorage('lat')) * cos($this->getFromStorage('lon')))
            )->setInStorage('y',
                (
                    $this->getFromStorage('y') +
                    cos($this->getFromStorage('lat')) * sin($this->getFromStorage('lon'))
                )
            )->setInStorage('z', (
                $this->getFromStorage('z') +
                sin($this->getFromStorage('lat')))
            );
        }

        $this->resolveDimensionByPointsCount();

        $this->resolveCoordinates();

        $this->setResult([
            'lat' => $this->getFromStorage('lat') * 180 / pi(),
            'long' => $this->getFromStorage('long') * 180 / pi()
        ]);

        return $this->getResult();
    }

    /**
     * description
     *
     * @author karam mustafa
     */
    public function resetDimensions()
    {
        $this->setInStorage('x', 0.0)
            ->setInStorage('y', 0.0)
            ->setInStorage('z', 0.0)
            ->setInStorage('dimensions', ['x', 'y', 'z']);
    }

    /**
     * description
     *
     * @author karam mustafa
     */
    private function resolveDimensionByPointsCount()
    {
        foreach ($this->getFromStorage('dimensions') as $dimension) {
            $this->setInStorage(
                $dimension,
                ($this->getFromStorage($dimension) / $this->getFromStorage('pointsCount'))
            );
        }
    }

    /**
     * description
     *
     * @author karam mustafa
     */
    private function resolveCoordinates()
    {
        $this->setInStorage('long', atan2(
            $this->getFromStorage('y'), $this->getFromStorage('x')
        ))->setInStorage('multiplied y',
            ($this->getFromStorage('y') * $this->getFromStorage('y'))
        )->setInStorage('multiplied x',
            ($this->getFromStorage('x') * $this->getFromStorage('x'))
        )->setInStorage(
            'distance',
            sqrt($this->getFromStorage('multiplied x') + $this->getFromStorage('multiplied y'))
        )->setInStorage('lat',
            atan2($this->getFromStorage('z'), $this->getFromStorage('distance'))
        );
    }
}
