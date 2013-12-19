<?php

interface Buric_Cache_Model_Cache_Interface
{
    public function registry($key, $callback, $ttl);
    public function delete($key);
}
