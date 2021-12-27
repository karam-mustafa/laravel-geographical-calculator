<?php


namespace KMLaravel\GeographicalCalculator\Traits;


trait AngleStorage
{
    /**
     * @author karam mustafa
     *
     * @var array
     */
    private $longs = [];
    /**
     * sin value.
     *
     * @author karam mustafa
     *
     * @var float|int
     */
    private $sin;
    /**
     * cos value.
     *
     * @author karam mustafa
     *
     * @var float|int
     */
    private $cos;

    /**
     * @return float|int
     *
     * @author karam mustaf
     */
    public function getSin()
    {
        return $this->sin;
    }

    /**
     * @param  float|int  $sin
     *
     * @return AngleStorage
     *
     * @author karam mustaf
     */
    public function setSin($sin)
    {
        $this->sin = $sin;

        return $this;
    }

    /**
     * @return float|int
     *
     * @author karam mustaf
     */
    public function getCos()
    {
        return $this->cos;
    }

    /**
     * @return mixed
     *
     * @author karam mustaf
     */
    public function getLongs()
    {
        return $this->longs;
    }

    /**
     * @param $val
     *
     * @return AngleStorage
     *
     * @author karam mustaf
     */
    public function setLongitude($val)
    {
        $this->longs[] = $val;

        return $this;
    }

    /**
     * @param  float|int  $cos
     *
     * @return AngleStorage
     *
     * @author karam mustaf
     */
    public function setCos($cos)
    {
        $this->cos = $cos;

        return $this;
    }

    /**
     * clear all stored angles.
     *
     * @author karam mustafa
     */
    public function clearAngles()
    {
        $this->setSin('');
        $this->setCos('');
        $this->clearLongs();
    }

    /**
     * clear Longs.
     *
     * @author karam mustafa
     */
    private function clearLongs()
    {
        $this->longs = [];
    }

}
