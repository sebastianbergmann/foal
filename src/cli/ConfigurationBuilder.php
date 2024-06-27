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

use function assert;
use function is_array;
use SebastianBergmann\CliParser\Exception as CliParserException;
use SebastianBergmann\CliParser\Parser as CliParser;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class ConfigurationBuilder
{
    /**
     * @param list<non-empty-string> $argv
     *
     * @throws ConfigurationBuilderException
     */
    public function build(array $argv): Configuration
    {
        try {
            $options = (new CliParser)->parse(
                $argv,
                'hv',
                [
                    'paths=',
                    'help',
                    'version',
                ],
            );
            // @codeCoverageIgnoreStart
        } catch (CliParserException $e) {
            throw new ConfigurationBuilderException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
            // @codeCoverageIgnoreEnd
        }

        $paths   = null;
        $help    = false;
        $version = false;

        foreach ($options[0] as $option) {
            assert(is_array($option));

            switch ($option[0]) {
                case '--paths':
                    $paths = (string) $option[1];

                    assert($paths !== '');

                    break;

                case 'h':
                case '--help':
                    $help = true;

                    break;

                case 'v':
                case '--version':
                    $version = true;

                    break;
            }
        }

        return new Configuration(
            $options[1],
            $paths,
            $help,
            $version,
        );
    }
}
