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

use function dirname;
use SebastianBergmann\Version as VersionId;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final class Version
{
    private static string $pharVersion = '';
    private static string $version     = '';

    public static function id(): string
    {
        if (self::$pharVersion !== '') {
            // @codeCoverageIgnoreStart
            return self::$pharVersion;
            // @codeCoverageIgnoreEnd
        }

        if (self::$version === '') {
            self::$version = (new VersionId('0.4', dirname(__DIR__, 2)))->asString();
        }

        return self::$version;
    }
}
