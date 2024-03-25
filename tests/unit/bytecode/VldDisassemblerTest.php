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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VldDisassembler::class)]
#[UsesClass(VldParser::class)]
#[Small]
#[TestDox('VldDisassembler')]
#[RequiresPhpExtension('vld')]
#[RequiresPhpExtension('Zend OPcache')]
final class VldDisassemblerTest extends TestCase
{
    public function testFindsLinesWithOpcodesBeforeOptimization(): void
    {
        $this->assertSame(
            [4, 6, 7, 8],
            $this->disassembler()->linesWithOpcodesBeforeOptimization(__DIR__ . '/../../fixture/source.php'),
        );
    }

    public function testFindsLinesWithOpcodesAfterOptimization(): void
    {
        $this->assertSame(
            [6, 8],
            $this->disassembler()->linesWithOpcodesAfterOptimization(__DIR__ . '/../../fixture/source.php'),
        );
    }

    public function testFindsPathsBeforeOptimization(): void
    {
        $this->assertStringMatchesFormatFile(
            __DIR__ . '/../../expectations/before-optimization.dot',
            $this->disassembler()->pathsBeforeOptimization(__DIR__ . '/../../fixture/source.php'),
        );
    }

    public function testFindsPathsAfterOptimization(): void
    {
        $this->assertStringMatchesFormatFile(
            __DIR__ . '/../../expectations/after-optimization.dot',
            $this->disassembler()->pathsAfterOptimization(__DIR__ . '/../../fixture/source.php'),
        );
    }

    private function disassembler(): VldDisassembler
    {
        return new VldDisassembler(new VldParser);
    }
}
