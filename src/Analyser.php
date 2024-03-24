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
    private ByteCodeDumper $byteCodeDumper;

    public function __construct(ByteCodeDumper $byteCodeDumper)
    {
        $this->byteCodeDumper = $byteCodeDumper;
    }

    /**
     * @psalm-param non-empty-string $filename
     */
    public function analyse(string $filename): File
    {
        return new File(
            file($filename),
            $this->linesEliminatedByOptimizer($filename),
        );
    }

    /**
     * @psalm-param non-empty-string $filename
     *
     * @psalm-return list<int>
     */
    private function linesEliminatedByOptimizer(string $filename): array
    {
        return array_values(
            array_diff(
                $this->byteCodeDumper->byteCode($filename),
                $this->byteCodeDumper->optimizedByteCode($filename),
            ),
        );
    }
}
