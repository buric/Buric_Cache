<?php

interface Buric_Cache_Model_Driver_Interface
{
    public function registry($key, $callback, $ttl);
    public function delete($key);
    public function checkConfiguration();
}
