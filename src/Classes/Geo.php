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
     * all the package feature, this array contains only the name of the feature
     * if you want to use the feature, then the feature should be such as a getter method.
     *
     * @example if you want to use distance => yous should resolve the selected key from this array
     * and add get key word.
     * ['distance' => 'getDistance']
     *
     * @author karam mustafa
     * @var array
     */
    private $allFeatures = [
        'Center',
        'Distance',
    ];

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

        foreach ($this->allFeatures as $feature) {
            if ($this->inStorage('points')) {
                $this->setPoint($this->getFromStorage('points'));
            } else {
                $this->setInStorage('points', $this->getPoints());
            }

            $this->setResult([strtolower($feature) => $this->{"get".$feature}()]);

            $this->clearPoints();
            $this->clearStorage();

        }
        return $this->getResult(function (Collection $results){
            return $results->only('center','distance');
        })->toArray();
    }
}
