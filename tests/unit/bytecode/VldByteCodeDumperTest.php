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
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VldByteCodeDumper::class)]
#[UsesClass(VldParser::class)]
#[Small]
final class VldByteCodeDumperTest extends TestCase
{
    public function testDumpsByteCode(): void
    {
        $dumper = new VldByteCodeDumper(new VldParser);

        $this->assertSame([4, 6, 7, 8], $dumper->byteCode(__DIR__ . '/../../fixture/source.php'));
    }

    public function testDumpsOptimizedByteCode(): void
    {
        $dumper = new VldByteCodeDumper(new VldParser);

        $this->assertSame([6, 8], $dumper->optimizedByteCode(__DIR__ . '/../../fixture/source.php'));
    }
}
