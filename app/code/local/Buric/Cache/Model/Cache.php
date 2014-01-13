<?php

/*
 * @author  Zvonimir Buric <zvonimir.buric@gmail.com>
 * @link    https://github.com/buric/Buric_Cache
 */

class Buric_Cache_Model_Cache implements Buric_Cache_Model_Cache_Interface
{
    /*
     * The driver object.
     */
    protected $driver;

    /*
     * Specify which caching driver are you going to use.
     * @param $driver Buric_Cache_Model_Driver_Interface
     */
    public function __construct(Buric_Cache_Model_Driver_Interface $driver) {
        $this->driver = $driver;

        $this->driver->checkConfiguration();
    }

    /*
     * Return the variable from the cache. If there is no such variable in the cache,
     * execute $callback function and save return value to the cache and return.
     *
     * $ttl - time to live (seconds)
     * If no $ttl is supplied (or if the ttl is 0), the value will persist until
     * it is removed from the cache manually.
     *
     * @param $key string
     * @param $callback function
     * @param $ttl int
     * @throws Exception If $key is not a string
     * @throws Exception If $callback is not callable
     * @return mixed
     */
    public function registry($key, $callback, $ttl = 0) {
        if(!is_string($key)) {
            throw new Exception(
                sprintf("Argument 1 passed to %s() must be an instance of string, %s given.", __METHOD__, gettype($key))
            );
        }

        if(!is_callable($callback)) {
            throw new Exception(
                sprintf("Argument 2 passed to %s() must be callable, %s given.", __METHOD__, gettype($callback))
            );
        }

        return $this->driver->registry($key, $callback, $ttl);
    }

    /*
     * Delete the variable from the cache.
     * @param $key string
     * @throws Exception If $key is not a string
     * @return bool
     */
    public function delete($key) {
        if(!is_string($key)) {
            throw new Exception(
                sprintf("Argument 1 passed to %s() must be an instance of string, %s given.", __METHOD__, gettype($key))
            );
        }

        return $this->driver->delete($key);
    }
}
