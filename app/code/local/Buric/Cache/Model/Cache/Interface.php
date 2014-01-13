<?php

/*
 * @author  Zvonimir Buric <zvonimir.buric@gmail.com>
 * @link    https://github.com/buric/Buric_Cache
 */

interface Buric_Cache_Model_Cache_Interface
{
    public function registry($key, $callback, $ttl);
    public function delete($key);
}
