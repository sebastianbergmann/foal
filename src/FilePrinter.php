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

use function array_flip;
use function array_key_exists;
use function printf;
use function rtrim;

final readonly class FilePrinter
{
    public function print(File $file): void
    {
        $sourceLines     = $file->sourceLines();
        $eliminatedLines = array_flip($file->linesEliminatedByOptimizer());
        $line            = 0;

        foreach ($sourceLines as $sourceLine) {
            $line++;

            printf(
                '%s %-6d %s' . PHP_EOL,
                array_key_exists($line, $eliminatedLines) ? '-' : ' ',
                $line,
                rtrim($sourceLine),
            );
        }
    }
}
