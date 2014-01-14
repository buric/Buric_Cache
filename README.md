#Buric_Cache

Magento extension for caching variables.
With this extension you can optimize your code to use the same variable in every request, 
without repeated generating of the variable.

The extension uses APC to save variables.
From version 0.2.0 you can use [eAccelerator](http://eaccelerator.net/) as caching engine.
You can use some other engine (e.g. [Memcache](http://www.php.net/memcache), [Redis](http://redis.io/)), just make sure you create the proper driver (implement ``Buric_Cache_Model_Driver_Interface``)

##Usage
Create instance of your driver and pass it to the cache object:
```php
$driver = Mage::getSingleton('buric_cache/driver_apc');
$cache = Mage::getSingleton('buric_cache/cache', $driver);

$eacceleratorDriver = Mage::getSingleton('buric_cache/driver_eaccelerator');
$cache = Mage::getSingleton('buric_cache/cache', $eacceleratorDriver);
```
###Saving and retrieving the variable - all in one
Use ``$cache->registry()`` method to retreive the variable from the cache. If there is no such variable in the cache, it will execute ``$callback`` function and save return value to the cache and return it. You can use ``$ttl`` to specify how long should the variable be in the cache (in seconds). If no ``$ttl`` is supplied (or if the ``$ttl`` is 0), the value will persist until it is removed from the cache manually.

```php
try {
    $var = $cache->registry('testkey', function () {
        sleep(2);
        return rand();
    }, 10);
    echo $var;
}
catch (Exception $e) {
    echo $e->getMessage();
}
```
####Example: Save a product to the cache
```php
$productId = 3;
$product = $cache->registry('PRODUCT_' . $productId, function () use ($productId) {
    return Mage::getModel('catalog/product')->load($productId);
}, 600);
Zend_Debug::dump($product);
```
####Example: Save a category to the cache
```php
$categoryId = 4;
$category = $cache->registry('CATEGORY_' . $categoryId, function () use ($categoryId) {
    return Mage::getModel('catalog/category')->load($categoryId);
});
Zend_Debug::dump($category);
```
####Example: Save a category collection to the cache
```php
$categories = $cache->registry('CATEGORIES', function () {
    return Mage::getModel('catalog/category')->getCollection()->load();
}, 100);
Zend_Debug::dump($categories);
```
####Example: Delete a variable from the cache
```php
$productId = 3;
$cache->delete('PRODUCT_' . $productId);
```




