<?php

namespace KMLaravel\GeographicalCalculator\Traits;

trait Debugger
{
    /**
     * @param mixed $any
     *
     * @return Debugger
     *
     * @author karam mustafa
     */
    private function debug($any)
    {
        dd($any);

        return $this;
    }
}
