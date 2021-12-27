<?php


namespace KMLaravel\GeographicalCalculator\Traits;


trait Looper
{


    /**
     * map through each item in data, and apply the inserted callback.
     *
     * @param $data
     * @param  callable  $callback
     *
     * @return void
     * @author karam mustafa
     */
    public function through($data, $callback)
    {
        foreach ($data as $index => $item) {
            $callback($index, $item);
        }
    }
}
