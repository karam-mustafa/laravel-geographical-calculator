<?php

namespace KMLaravel\GeographicalCalculator\Classes;

use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use KMLaravel\GeographicalCalculator\Traits\Areas;
use KMLaravel\GeographicalCalculator\Traits\Distances;
use KMLaravel\GeographicalCalculator\Traits\GeoTraitContainer;

class Geo extends AbstractGeo implements GeoInterface
{
    use GeoTraitContainer;
    use Areas;
    use Distances;

    /**
     * @inheritDoc
     */
    public function clearResult()
    {
        // at this time, the Distances trait use the storage
        // so we check if there is any property called result
        // we will empty these results
        if (property_exists(__CLASS__, 'result')) {
            $this->clearStoredResults();
            $this->clearPoints()->clearStorage();
        }

        return $this;
    }

    /**
     *
     * @inheritDoc
     */
    public function allFeature($callback = null)
    {
        return $this
            ->setInStorage('points', $this->getPoints())
            ->clearStoredResults()->clearPoints()
            ->setPoints($this->getFromStorage('points'))
            ->clearStorage()
            ->setInStorage('closest', $this->getClosest())
            ->setInStorage('distances', $this->getDistance())
            ->setInStorage('center', $this->getCenter())
            ->getFromStorage(['center', 'distances', 'closest']);
    }
}
