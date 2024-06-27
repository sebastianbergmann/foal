<?php declare(strict_types=1);
/*
 * This file is part of FOAL.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\FOAL;

use function array_unique;
use function explode;
use function sort;
use function str_starts_with;
use function trim;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class VldParser
{
    /**
     * @param list<string> $lines
     *
     * @return list<int>
     */
    public function linesWithOpcodes(array $lines): array
    {
        $linesWithOpcodes = [];
        $opArray          = false;

        foreach ($lines as $line) {
            if (str_starts_with($line, ';line')) {
                $opArray = true;

                continue;
            }

            if (trim($line) === ';') {
                $opArray = false;
            }

            if (!$opArray) {
                continue;
            }

            $linesWithOpcodes[] = (int) explode(';', $line)[1];
        }

        $linesWithOpcodes = array_unique($linesWithOpcodes);

        sort($linesWithOpcodes);

        return $linesWithOpcodes;
    }
}
