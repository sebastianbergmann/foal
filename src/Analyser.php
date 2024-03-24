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

use function array_diff;
use function array_values;
use function file;

final readonly class Analyser
{
    private LinesWithOpcodesFinder $finder;

    public function __construct(LinesWithOpcodesFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @psalm-param non-empty-list<non-empty-string> $files
     */
    public function analyse(array $files): FileCollection
    {
        $result = [];

        foreach ($files as $file) {
            $result[] = new File(
                $file,
                file($file),
                $this->linesEliminatedByOptimizer($file),
            );
        }

        return FileCollection::from(...$result);
    }

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    private function linesEliminatedByOptimizer(string $file): array
    {
        return array_values(
            array_diff(
                $this->finder->beforeOptimization($file),
                $this->finder->afterOptimization($file),
            ),
        );
    }
}
