<?php

namespace KMLaravel\GeographicalCalculator\Classes;

use Illuminate\Support\Collection;
use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeo;
use KMLaravel\GeographicalCalculator\Interfaces\GeoInterface;
use KMLaravel\GeographicalCalculator\Traits\Areas;
use KMLaravel\GeographicalCalculator\Traits\Distances;
use KMLaravel\GeographicalCalculator\Traits\GeoTraitContainer;
use KMLaravel\GeographicalCalculator\Traits\Ordering;

/**
 * Class Geo
 *
 * @author karam mustafa
 * @package KMLaravel\GeographicalCalculator\Classes
 */
class Geo extends AbstractGeo implements GeoInterface
{
    use GeoTraitContainer;
    use Areas;
    use Distances;
    use Ordering;

    /**
     * @inheritDoc
     */
    public function clearResult()
    {
        // At this time, the Distances trait use the storage,
        // so we check if there is any property called result,
        // we will empty these results.
        if (property_exists(__CLASS__, 'result')) {
            $this->clearStoredResults();
            $this->clearPoints();
            $this->clearStorage();
        }

        return $this;
    }

    /**
     *
     * @inheritDoc
     */
    public function allFeature($callback = null)
    {

        $this->setInStorage('distanceResult' , $this->getDistance())
            ->clearStoredResults()
            ->setInStorage('centerResult' , $this->getCenter())
            ->clearStoredResults();

        $this->setResult([
            "distance"  => $this->getFromStorage('distanceResult'),
            "center"  => $this->getFromStorage('centerResult'),
        ]);

        return $this->getResult();
    }
}
