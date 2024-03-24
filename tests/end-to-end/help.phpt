--TEST--
foal --help
--FILE--
<?php declare(strict_types=1);
namespace SebastianBergmann\FOAL\CLI;

require_once __DIR__ . '/../../vendor/autoload.php';

$_SERVER['argv'][] = '--help';

(new Factory)->createApplication()->run($_SERVER['argv']);
--EXPECTF--
foal %s by Sebastian Bergmann.

Usage:
  foal [options] <file>

  -h|--help                        Prints this usage information and exits
  --version                        Prints the version and exits
