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

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class File
{
    /**
     * @var non-empty-string
     */
    private string $path;

    /**
     * @var list<string>
     */
    private array $sourceLines;

    /**
     * @var list<int>
     */
    private array $linesEliminatedByOptimizer;

    /**
     * @param non-empty-string $path
     * @param list<string>     $sourceLines
     * @param list<int>        $linesEliminatedByOptimizer
     */
    public function __construct(string $path, array $sourceLines, array $linesEliminatedByOptimizer)
    {
        $this->path                       = $path;
        $this->sourceLines                = $sourceLines;
        $this->linesEliminatedByOptimizer = $linesEliminatedByOptimizer;
    }

    /**
     * @return non-empty-string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return list<string>
     */
    public function sourceLines(): array
    {
        return $this->sourceLines;
    }

    /**
     * @return list<int>
     */
    public function linesEliminatedByOptimizer(): array
    {
        return $this->linesEliminatedByOptimizer;
    }
}
