# Find Optimized-Away Lines (FOAL)

`foal` finds lines of code that are eliminated by OpCache's bytecode optimizer.

## Installation

The recommended way to use this tool is a [PHP Archive (PHAR)](https://php.net/phar):

```bash
$ wget https://phar.phpunit.de/foal.phar

$ php foal.phar --version
```

Furthermore, it is recommended to use [Phive](https://phar.io/) for installing and updating the tool dependencies of your project.

Alternatively, you may use [Composer](https://getcomposer.org/) to download and install this tool as well as its dependencies. [This is not recommended, though.](https://twitter.com/s_bergmann/status/999635212723212288)


## Usage

#### `example.php`
```php
<?php
function f()
{
    $result = 'result';

    return $result;
}
```

```
$ php foal.phar example.php
foal 0.1.0 by Sebastian Bergmann.

The OpCache optimizer eliminated the following sourcecode lines:

4          $result = 'result';
7      }
```
