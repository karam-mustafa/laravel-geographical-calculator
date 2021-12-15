<?php

namespace KMLaravel\GeographicalCalculator\Abstracts;

/**
 * Class AbstractGeo.
 *
 * @author karam mustafa
 */
abstract class AbstractGeo
{
    /**
     * @param mixed         $condition
     * @param null|callable $callback
     *
     * @return AbstractGeo
     *
     * @author karam mustaf
     */
    public function checkIf($condition, $callback = null)
    {
        if (isset($condition)) {
            if (isset($callback)) {
                return $callback();
            }
        }

        return $this;
    }
}
