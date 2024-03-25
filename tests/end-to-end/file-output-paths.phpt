--TEST--
foal --paths /tmp tests/fixture/source.php
--SKIPIF--
<?php declare(strict_types=1);
if (!extension_loaded('Zend OPcache')) print 'skip: opcache not loaded' . PHP_EOL;
if (!extension_loaded('vld')) print 'skip: vld not loaded' . PHP_EOL;
--FILE--
<?php declare(strict_types=1);
namespace SebastianBergmann\FOAL\CLI;

require_once __DIR__ . '/../../vendor/autoload.php';

$_SERVER['argv'][] = '--paths';
$_SERVER['argv'][] = '/tmp';
$_SERVER['argv'][] = __DIR__ . '/../fixture/source.php';

(new Factory)->createApplication()->run($_SERVER['argv']);
--EXPECTF--
foal %s by Sebastian Bergmann.

Wrote execution paths for %ssource.php to /tmp/unoptimized.dot
Wrote optimized execution paths for %ssource.php to /tmp/optimized.dot
