<?php

namespace KMLaravel\GeographicalCalculator\Traits;

/**
 * Trait DataStorage.
 *
 * @author karam mustafa
 */
trait DataStorage
{
    /**
     * this property save any key with his value in a custom key.
     * if we want to store something instead of declare a variable and pass it as parameter
     * in any function, we use this property as a public property to share the data in classes.
     *
     * @author karam mustafa
     *
     * @var array
     */
    private $localStorage = [];
    /**
     * results.
     *
     * @author karam mustafa
     *
     * @var array
     */
    private $result = [];
    /**
     * for develop and resolve any options.
     *
     * @author karam mustafa
     *
     * @var array
     */
    private $options = [];

    /**
     * @param  mixed  $key
     *
     * @return array
     *
     * @author karam mustaf
     */
    public function getOptions($key = null)
    {
        return isset($this->options[$key])
            ? $this->options[$key]
            : $this->options;
    }

    /**
     * @param  array  $options
     *
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

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
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function setResult($result)
    {
        $this->result = array_merge($this->result, $result);

        return $this;
    }

    /**
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function clearStoredResults()
    {
        $this->result = [];

        return $this;
    }

    /**
     * @param  string  $key
     *
     * @return mixed
     *
     * @author karam mustaf
     */
    public function getFromStorage($key = null)
    {
        return isset($this->localStorage[$key])
            ? $this->localStorage[$key]
            : $this->localStorage;
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function setInStorage($key, $value)
    {
        $this->localStorage[$key] = $value;

        return $this;
    }

    /**
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function clearStorage()
    {
        $this->localStorage = [];

        return $this;
    }

    /**
     * @param  mixed  $keys
     *
     * @return DataStorage
     *
     * @author karam mustaf
     */
    public function removeFromStorage(...$keys)
    {
        foreach ($keys as $key) {
            if (isset($this->localStorage[$key])) {
                unset($this->localStorage[$key]);
            }
        }

        return $this;
    }
}
