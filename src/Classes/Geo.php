<?php

namespace KMLaravel\GeographicalCalculator\Classes;

use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use KMLaravel\GeographicalCalculator\Traits\Areas;
use KMLaravel\GeographicalCalculator\Traits\Distances;

class Geo extends AbstractGeo implements GeoInterface
{
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
        }

        return $this;
    }

    /**
     * todo implement feature container in v2.2.0.
     *
     * @inheritDoc
     */
    public function all($callback = null)
    {
        return $this->setInStorage('distances', $this->getDistance())
            ->clearResult()
            ->setInStorage('center', $this->getCenter())
            ->getFromStorage(['center' , 'distances']);

    }
}
