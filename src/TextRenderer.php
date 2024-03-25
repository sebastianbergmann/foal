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
use function rtrim;
use function sprintf;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class TextRenderer implements Renderer
{
    public function render(File $file): string
    {
        $buffer          = $file->path() . PHP_EOL;
        $sourceLines     = $file->sourceLines();
        $eliminatedLines = array_flip($file->linesEliminatedByOptimizer());
        $line            = 0;

        foreach ($sourceLines as $sourceLine) {
            $line++;

            $buffer .= sprintf(
                '%s %-6d %s' . PHP_EOL,
                array_key_exists($line, $eliminatedLines) ? '-' : ' ',
                $line,
                rtrim($sourceLine),
            );
        }

        return $buffer;
    }
}
