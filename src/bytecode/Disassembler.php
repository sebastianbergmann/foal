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
 * @internal This interface is not covered by the backward compatibility promise for FOAL
 */
interface Disassembler
{
    /**
     * @param non-empty-string $file
     *
     * @return list<int>
     */
    public function linesWithOpcodesBeforeOptimization(string $file): array;

    /**
     * @param non-empty-string $file
     *
     * @return list<int>
     */
    public function linesWithOpcodesAfterOptimization(string $file): array;

    /**
     * @param non-empty-string $file
     *
     * @return non-empty-string
     */
    public function pathsBeforeOptimization(string $file): string;

    /**
     * @param non-empty-string $file
     *
     * @return non-empty-string
     */
    public function pathsAfterOptimization(string $file): string;
}
