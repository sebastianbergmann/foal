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

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class Analyser
{
    private Disassembler $disassembler;

    public function __construct(Disassembler $disassembler)
    {
        $this->disassembler = $disassembler;
    }

    /**
     * @param non-empty-list<non-empty-string> $files
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
     * @param non-empty-string $file
     *
     * @return list<int>
     */
    private function linesEliminatedByOptimizer(string $file): array
    {
        return array_values(
            array_diff(
                $this->disassembler->linesWithOpcodesBeforeOptimization($file),
                $this->disassembler->linesWithOpcodesAfterOptimization($file),
            ),
        );
    }
}
