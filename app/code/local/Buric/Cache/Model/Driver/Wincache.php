<?php

/*
 * Implementation of the Wincache driver.
 *
 * @author  Zvonimir Buric <zvonimir.buric@gmail.com>
 * @link    https://github.com/buric/Buric_Cache
 */

class Buric_Cache_Model_Driver_Wincache implements Buric_Cache_Model_Driver_Interface
{
    /*
     * Implementation of the registry method for Wincache engine.
     */
    public function registry($key, $callback, $ttl = 0) {
        $saved = wincache_ucache_get($key, $success);
        if($success) {
            return $saved;
        }
        $value = $callback();
        wincache_ucache_set($key, $value, $ttl);
        return $value;
    }

    /*
     * Implementation of the delete method for Wincache engine.
     */
    public function delete($key) {
        return wincache_ucache_delete($key);
    }

    /*
     * Implementation of the checkConfiguration method for Wincache engine.
     */
    public function checkConfiguration() {
        if(!function_exists('wincache_ucache_get')) {
            throw new Exception("Wincache extension is not installed.");
        }
    }
}
