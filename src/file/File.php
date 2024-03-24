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

final readonly class File
{
    /**
     * @psalm-var list<string>
     */
    private array $sourceLines;

    /**
     * @psalm-var list<int>
     */
    private array $linesEliminatedByOptimizer;

    /**
     * @psalm-param list<string> $sourceLines
     * @psalm-param list<int> $linesEliminatedByOptimizer
     */
    public function __construct(array $sourceLines, array $linesEliminatedByOptimizer)
    {
        $this->sourceLines                = $sourceLines;
        $this->linesEliminatedByOptimizer = $linesEliminatedByOptimizer;
    }

    /**
     * @psalm-return list<string>
     */
    public function sourceLines(): array
    {
        return $this->sourceLines;
    }

    /**
     * @psalm-return list<int>
     */
    public function linesEliminatedByOptimizer(): array
    {
        return $this->linesEliminatedByOptimizer;
    }
}
