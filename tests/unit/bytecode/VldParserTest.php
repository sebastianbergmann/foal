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

use function assert;
use function file;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(VldParser::class)]
#[Small]
#[TestDox('VldParser')]
final class VldParserTest extends TestCase
{
    /**
     * @return non-empty-array<non-empty-string, array{0: list<int>, 1: non-empty-string}>
     */
    public static function provider(): array
    {
        return [
            'before optimization' => [
                [4, 6, 7, 8],
                __DIR__ . '/../../fixture/source.bytecode',
            ],

            'after optimization' => [
                [6, 8],
                __DIR__ . '/../../fixture/source.optimized-bytecode',
            ],
        ];
    }

    /**
     * @param list<int> $expected
     */
    #[DataProvider('provider')]
    #[TestDox('Parses VLD bytecode dump')]
    public function testParsesVldBytecodeDump(array $expected, string $filename): void
    {
        $parser = new VldParser;

        $lines = file($filename);

        assert($lines !== false);

        $this->assertSame($expected, $parser->linesWithOpcodes($lines));
    }
}
