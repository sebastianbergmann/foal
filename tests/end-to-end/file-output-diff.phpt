--TEST--
foal --diff tests/fixture/source.php
--SKIPIF--
<?php declare(strict_types=1);
if (!extension_loaded('Zend OPcache')) print 'skip: opcache not loaded' . PHP_EOL;
if (!extension_loaded('vld')) print 'skip: vld not loaded' . PHP_EOL;
--FILE--
<?php declare(strict_types=1);
namespace SebastianBergmann\FOAL\CLI;

require_once __DIR__ . '/../../vendor/autoload.php';

$_SERVER['argv'][] = '--diff';
$_SERVER['argv'][] = __DIR__ . '/../fixture/source.php';

(new Factory)->createApplication()->run($_SERVER['argv']);
--EXPECTF--
foal %s by Sebastian Bergmann.

--- %ssource.php
+++ %ssource.php (optimized)
@@ -1,7 +1,7 @@
 <?php declare(strict_types=1);
 function f()
 {
-    $result = 'result';
+ 
     return $result;
-}
+
\ No newline at end of file
