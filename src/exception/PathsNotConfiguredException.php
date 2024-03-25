<?php declare(strict_types=1);
/*
 * This file is part of FOAL.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\FOAL\CLI;

use RuntimeException;
use SebastianBergmann\FOAL\Exception;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final class PathsNotConfiguredException extends RuntimeException implements Exception
{
}
