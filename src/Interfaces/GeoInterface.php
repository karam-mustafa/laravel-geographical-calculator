<?php


namespace KMLaravel\GeographicalCalculator\Interfaces;

interface GeoInterface
{
    /**
     *
     * @param  array  $point
     *
     * @author karam mustafa
     */
    function setPoint($point);

    /**
     * Finding the distance of points using several given coordinate points.
     *
     * @author karam mustafa
     * @author karam mustafa
     */
    function getDistance();

    /**
     * Finding the center of points using several given coordinate points
     *
     * @author karam mustafa
     * @author karam mustafa
     */
    function getCenter();
}
