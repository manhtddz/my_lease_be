<?php

namespace App\Services\Cache;

trait TraitCacheService
{
    /**
     * @var array
     */
    protected $_cache = [];

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function cache($key, $value)
    {
        if ($this->hasCache($key)) {
            return $this->getCache($key);
        }
        $val = $value();
        $this->setCache($key, $val);
        return $val;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getCache($key)
    {
        return data_get($this->_cache, $key, []);
    }

    /**
     * @param $key
     * @param $cache
     */
    public function setCache($key, $cache)
    {
        $this->_cache[$key] = $cache;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasCache($key)
    {
        return isset($this->_cache[$key]);
    }
}
