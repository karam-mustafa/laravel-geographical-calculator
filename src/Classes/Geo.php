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
}
