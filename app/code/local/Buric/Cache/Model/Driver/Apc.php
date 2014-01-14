<?php

/*
 * Implementation of the APC driver.
 *
 * @author  Zvonimir Buric <zvonimir.buric@gmail.com>
 * @link    https://github.com/buric/Buric_Cache
 */

class Buric_Cache_Model_Driver_Apc implements Buric_Cache_Model_Driver_Interface
{
    /*
     * Implementation of the registry method for APC engine.
     */
    public function registry($key, $callback, $ttl = 0) {
        $saved = apc_fetch($key, $success);
        if($success) {
            return $saved;
        }
        $value = $callback();
        apc_store($key, $value, $ttl);
        return $value;
    }

    /*
     * Implementation of the delete method for APC engine.
     */
    public function delete($key) {
        return apc_delete($key);
    }

    /*
     * Implementation of the checkConfiguration method for APC engine.
     */
    public function checkConfiguration() {
        if(!extension_loaded('apc')) {
            throw new Exception("APC extension is not loaded.");
        }

        if(!ini_get('apc.enabled')) {
            throw new Exception("APC extension is not enabled.");
        }
    }
}
