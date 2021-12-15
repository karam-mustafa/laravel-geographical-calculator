<?php

namespace KMLaravel\GeographicalCalculator\Interfaces;

interface GeoInterface
{
    /**
     * @param array $point
     *
     * @author karam mustafa
     */
    public function setPoint($point);

    /**
     * Finding the distance of points using several given coordinate points.
     *
     * @author karam mustafa
     * @author karam mustafa
     */
    public function getDistance();

    /**
     * Finding the center of points using several given coordinate points.
     *
     * @author karam mustafa
     * @author karam mustafa
     */
    public function getCenter();
}
