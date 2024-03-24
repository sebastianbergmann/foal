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

interface LinesWithOpcodesFinder
{
    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function beforeOptimization(string $file): array;

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function afterOptimization(string $file): array;
}
