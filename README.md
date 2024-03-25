[![No Maintenance Intended](https://unmaintained.tech/badge.svg)](https://unmaintained.tech/)
[![CI Status](https://github.com/sebastianbergmann/foal/workflows/CI/badge.svg)](https://github.com/sebastianbergmann/foal/actions)
[![Type Coverage](https://shepherd.dev/github/sebastianbergmann/foal/coverage.svg)](https://shepherd.dev/github/sebastianbergmann/foal)
[![codecov](https://codecov.io/gh/sebastianbergmann/foal/branch/main/graph/badge.svg)](https://codecov.io/gh/sebastianbergmann/foal)

# Find Optimized-Away Lines (FOAL)

`foal` finds lines of code that are eliminated by OpCache's bytecode optimizer.

## Installation

The recommended way to use this tool is a [PHP Archive (PHAR)](https://php.net/phar):

```bash
$ wget https://phar.phpunit.de/foal.phar

$ php foal.phar --version
```

Furthermore, it is recommended to use [Phive](https://phar.io/) for installing and updating the tool dependencies of your project.

## Usage

**`example.php`**
```php
<?php declare(strict_types=1);
function f()
{
    $result = 'result';

    return $result;
}
```

### Default Output
```
$ php foal.phar example.php
foal 0.3.0 by Sebastian Bergmann.

  1      <?php declare(strict_types=1);
  2      function f()
  3      {
- 4          $result = 'result';
  5      
  6          return $result;
- 7      }
```

Lines prefixed with `-` were optimized away by the OpCache bytecode optimizer.
