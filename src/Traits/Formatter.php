<?php


namespace KMLaravel\GeographicalCalculator\Traits;


trait Formatter
{

    /**
     * @param  string  $key
     *
     * @return float
     * @author karam mustafa
     */
    private function formatDistanceKey($key)
    {
        return config('geographical_calculator.distance_key_prefix') ?? ""."$key";
    }
}
