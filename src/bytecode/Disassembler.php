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

interface Disassembler
{
    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function linesWithOpcodesBeforeOptimization(string $file): array;

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function linesWithOpcodesAfterOptimization(string $file): array;

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return non-empty-string
     */
    public function pathsBeforeOptimization(string $file): string;

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return non-empty-string
     */
    public function pathsAfterOptimization(string $file): string;
}
