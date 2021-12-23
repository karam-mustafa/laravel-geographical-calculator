<?php

namespace KMLaravel\GeographicalCalculator\Interfaces;

interface GeoInterface
{
    /**
     * @param  array  $point
     *
     * @author karam mustafa
     */
    public function setPoint($point);

    /**
     * Finding the distance of points using several given coordinate points.
     *
     * @author karam mustafa
     */
    public function getDistance();

    /**
     * Finding the center of points using several given coordinate points.
     *
     * @author karam mustafa
     */
    public function getCenter();

    /**
     * clear all stored results
     *
     * @return  GeoInterface
     * @author karam mustafa
     */
    public function clearResult();

    /**
     * get all package features.
     *
     * @return  array
     * @author karam mustafa
     */
    public function allFeature();
}
