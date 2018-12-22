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

use PHPUnit\Framework\TestCase;

final class AnalyserTest extends TestCase
{
    protected function setUp(): void
    {
        if (!\extension_loaded('Zend OPcache')) {
            $this->markTestSkipped('OpCache is not available');
        }

        if (!\extension_loaded('vld')) {
            $this->markTestSkipped('VLD is not available');
        }
    }

    public function testFindsLinesEliminatedByOptimizer(): void
    {
        $analyser = new Analyser;

        $this->assertSame(
            [
                0 => 4,
                2 => 7
            ],
            $analyser->linesEliminatedByOptimizer(__DIR__ . '/../_fixture/example.php')
        );
    }
}
