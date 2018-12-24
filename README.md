# Find Optimized-Away Lines (FOAL)

`foal` finds lines of code that are eliminated by OpCache's bytecode optimizer.

## Installation

### PHP Archive (PHAR)

The easiest way to obtain `foal`is to download a [PHP Archive (PHAR)](https://php.net/phar) that has all required dependencies bundled in a single file:

```
$ wget https://phar.phpunit.de/foal.phar
```

### Composer

You can add this tool as a local, per-project, development-time dependency to your project using [Composer](https://getcomposer.org/):

```
$ composer require --dev sebastian/foal
```

You can then invoke it using the `./vendor/bin/foal` executable.


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
