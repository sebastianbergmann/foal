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
final readonly class ArgumentsBuilder
{
    /**
     * @psalm-param list<non-empty-string> $argv
     *
     * @throws ArgumentsBuilderException
     */
    public function build(array $argv): Arguments
    {
        try {
            $options = (new CliParser)->parse(
                $argv,
                'hv',
                [
                    'help',
                    'version',
                ],
            );
            // @codeCoverageIgnoreStart
        } catch (CliParserException $e) {
            throw new ArgumentsBuilderException(
                $e->getMessage(),
                $e->getCode(),
                $e,
            );
            // @codeCoverageIgnoreEnd
        }

        $help    = false;
        $version = false;

        foreach ($options[0] as $option) {
            assert(is_array($option));

            switch ($option[0]) {
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

        return new Arguments(
            $options[1],
            $help,
            $version,
        );
    }
}
