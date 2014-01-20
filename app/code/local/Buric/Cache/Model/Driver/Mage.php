<?php

/*
 * Implementation of the Mage driver.
 *
 * @author  Zvonimir Buric <zvonimir.buric@gmail.com>
 * @link    https://github.com/buric/Buric_Cache
 */

class Buric_Cache_Model_Driver_Mage implements Buric_Cache_Model_Driver_Interface
{
    /*
     * The engine variable.
     */
    protected $_engine;

    /*
     * Initialize the engine.
     */
    public function __construct() {
        $this->_engine = Mage::app()->getCache();
    }

    /*
     * Implementation of the registry method for Mage engine.
     */
    public function registry($key, $callback, $ttl = 0) {
        $saved = $this->_engine->load($key);
        if($saved) {
            return unserialize($saved);
        }

        // magento cache ttl -> really 0 seconds; convert to null to persist
        if(!$ttl) {
            $ttl = null;
        }

        $value = $callback();
        $this->_engine->save(serialize($value), $key, array(), $ttl);
        return $value;
    }

    /*
     * Implementation of the delete method for Mage engine.
     */
    public function delete($key) {
        return $this->_engine->remove($key);
    }

    /*
     * Implementation of the checkConfiguration method for Mage engine.
     */
    public function checkConfiguration() {
	
	}
}
