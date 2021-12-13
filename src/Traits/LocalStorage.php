<?php


namespace KMLaravel\GeographicalCalculator\Traits;


use KMLaravel\GeographicalCalculator\Abstracts\AbstractGeo;

/**
 * Trait LocalStorage
 *
 * @author karam mustafa
 * @package KMLaravel\GeographicalCalculator\Traits
 */
trait LocalStorage
{

    /**
     * this property save any key with his value in a custom key.
     * if we want to store something instead of declare a variable and pass it as parameter
     * in any function, we use this property as a public property to share the data in classes.
     *
     * @author karam mustafa
     * @var array
     */
    private $localStorage = [];
    /**
     * results
     *
     * @author karam mustafa
     * @var array
     */
    private $result = [];

    /**
     * @return mixed
     *
     * @author karam mustaf
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param  mixed  $result
     *
     * @return LocalStorage
     * @author karam mustaf
     */
    public function setResult($result)
    {
        $this->result = array_merge($this->result, $result);

        return $this;
    }

    /**
     * @param  string  $key
     *
     * @return mixed
     *
     * @author karam mustaf
     */
    public function getFromLocalStorage($key = null)
    {
        return isset($this->localStorage[$key])
            ? $this->localStorage[$key]
            : $this->localStorage;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     *
     * @param  array  $options
     *
     * @return LocalStorage
     * @author karam mustaf
     */
    public function setInLocalStorage($key, $value, $options = ['new' => false])
    {
        $this->localStorage[$key] = $value;

        return $this;
    }

    /**
     * @return LocalStorage
     * @author karam mustaf
     */
    public function clearLocalStorage()
    {
        $this->localStorage = [];

        return $this;
    }

    /**
     * @param  mixed  $keys
     *
     * @return LocalStorage
     * @author karam mustaf
     */
    public function removeFromLocalStorage(...$keys)
    {
        foreach ($keys as $key) {
            if (isset($this->localStorage[$key])) {
                unset($this->localStorage[$key]);
            }
        }

        return $this;
    }
}
