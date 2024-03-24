--TEST--
foal tests/fixture
--SKIPIF--
<?php declare(strict_types=1);
if (!extension_loaded('Zend OPcache')) print 'skip: opcache not loaded' . PHP_EOL;
if (!extension_loaded('vld')) print 'skip: vld not loaded' . PHP_EOL;
--FILE--
<?php declare(strict_types=1);
namespace SebastianBergmann\FOAL\CLI;

require_once __DIR__ . '/../../vendor/autoload.php';

$_SERVER['argv'][] = __DIR__ . '/../fixture';

(new Factory)->createApplication()->run($_SERVER['argv']);
--EXPECTF--
foal %s by Sebastian Bergmann.

%ssource.php
  1      <?php declare(strict_types=1);
  2      function f()
  3      {
- 4          $result = 'result';
  5      
  6          return $result;
- 7      }

%ssource2.php
  1      <?php declare(strict_types=1);
  2      function f()
  3      {
- 4          $result = 'result';
  5      
  6          return $result;
- 7      }
