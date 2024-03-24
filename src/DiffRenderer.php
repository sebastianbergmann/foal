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

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;

final readonly class DiffRenderer
{
    public function render(File $file): string
    {
        $before = $file->sourceLines();
        $after  = $before;

        foreach ($file->linesEliminatedByOptimizer() as $line) {
            $after[$line - 1] = '';
        }

        $differ = new Differ(
            new StrictUnifiedDiffOutputBuilder(
                [
                    'fromFile' => $file->path(),
                    'toFile'   => $file->path() . ' (optimized)',
                ],
            ),
        );

        return $differ->diff($before, $after);
    }
}
