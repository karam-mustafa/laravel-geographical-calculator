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
            $lat = $point[0] * pi() / 180;
            $lon = $point[1] * pi() / 180;
            // set x,y,z
            $this->setInStorage('x', ($this->getFromStorage('x') + cos($lat) * cos($lon)))
                ->setInStorage('y', ($this->getFromStorage('y') + cos($lat) * sin($lon)))
                ->setInStorage('z', ($this->getFromStorage('z') + sin($lat)));
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
        ));

        $this->setInStorage('multiplied y', ($this->getFromStorage('y') * $this->getFromStorage('y')));
        $this->setInStorage('multiplied x', ($this->getFromStorage('x') * $this->getFromStorage('x')));

        $this->setInStorage(
            'distance',
            sqrt($this->getFromStorage('multiplied x') + $this->getFromStorage('multiplied y'))
        );
        $this->setInStorage('lat', atan2($this->getFromStorage('z'), $this->getFromStorage('distance')));
    }
}
