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

final class Analyser
{
    private const VLD_OPTIONS = '-d vld.active=1 -d vld.execute=0 -d vld.verbosity=0 -d vld.format=1 -d vld.col_sep=\';\'';

    private const OPCACHE_OPTIONS = '-d opcache.enable_cli=1 -d opcache.optimization_level=-1';

    /**
     * @return int[]
     */
    public function linesEliminatedByOptimizer(string $filename): array
    {
        return \array_diff(
            $this->getByteCode($filename),
            $this->getOptimizedByteCode($filename)
        );
    }

    /**
     * @return int[]
     */
    private function getByteCode(string $filename): array
    {
        return $this->linesWithOpcodes(
            $this->execute(
                \PHP_BINARY . ' ' . self::VLD_OPTIONS . ' ' . $filename . ' 2>&1'
            )
        );
    }

    /**
     * @return int[]
     */
    private function getOptimizedByteCode(string $filename): array
    {
        return $this->linesWithOpcodes(
            $this->execute(
                \PHP_BINARY . ' ' . self::VLD_OPTIONS . ' ' . self::OPCACHE_OPTIONS . ' ' . $filename . ' 2>&1'
            )
        );
    }

    /**
     * @return string[]
     */
    private function execute(string $command): array
    {
        \exec($command, $output, $returnValue);

        if ($returnValue !== 0) {
            throw new RuntimeException(\implode("\r\n", $output));
        }

        return $output;
    }

    /**
     * @return int[]
     */
    private function linesWithOpcodes(array $lines): array
    {
        $linesWithOpcodes = [];
        $opArray          = false;

        foreach ($lines as $line) {
            if (\strpos($line, ';line') === 0) {
                $opArray = true;

                continue;
            }

            if ($line === ';') {
                $opArray = false;
            }

            if (!$opArray) {
                continue;
            }

            $linesWithOpcodes[] = (int) \explode(';', $line)[1];
        }

        $linesWithOpcodes = \array_unique($linesWithOpcodes);
        \sort($linesWithOpcodes);

        return $linesWithOpcodes;
    }
}
