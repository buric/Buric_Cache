<?php

/*
 * Implementation of the Eaccelerator driver.
 *
 * @author  Zvonimir Buric <zvonimir.buric@gmail.com>
 * @link    https://github.com/buric/Buric_Cache
 */

class Buric_Cache_Model_Driver_Eaccelerator implements Buric_Cache_Model_Driver_Interface
{
    /*
     * Implementation of the registry method for Eaccelerator engine.
     */
    public function registry($key, $callback, $ttl = 0) {
        $saved = eaccelerator_get($key);
        if($saved !== false) {
            return $saved;
        }
        $value = $callback();
        eaccelerator_put($key, $value, $ttl);
        return $value;
    }

    /*
     * Implementation of the delete method for Eaccelerator engine.
     */
    public function delete($key) {
        return eaccelerator_rm($key);
    }

    /*
     * Implementation of the checkConfiguration method for Eaccelerator engine.
     */
    public function checkConfiguration() {
        if(!function_exists('eaccelerator')) {
            throw new Exception("Eaccelerator extension is not installed.");
        }
    }
}
