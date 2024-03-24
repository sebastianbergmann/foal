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
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VldLinesWithOpcodesFinder::class)]
#[UsesClass(VldParser::class)]
#[Small]
#[TestDox('VldLinesWithOpCodesFinder')]
final class VldLinesWithOpCodesFinderTest extends TestCase
{
    public function testFindsLinesWithOpcodesBeforeOptimization(): void
    {
        $dumper = new VldLinesWithOpcodesFinder(new VldParser);

        $this->assertSame([4, 6, 7, 8], $dumper->beforeOptimization(__DIR__ . '/../../fixture/source.php'));
    }

    public function testFindsLinesWithOpcodesAfterOptimization(): void
    {
        $dumper = new VldLinesWithOpcodesFinder(new VldParser);

        $this->assertSame([6, 8], $dumper->afterOptimization(__DIR__ . '/../../fixture/source.php'));
    }
}
