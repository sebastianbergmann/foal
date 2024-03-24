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

use function file;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(File::class)]
#[Small]
#[TestDox('File')]
final class FileTest extends TestCase
{
    public function testHasSourceLines(): void
    {
        $this->assertSame(
            file(__DIR__ . '/../../fixture/source.php'),
            $this->file()->sourceLines(),
        );
    }

    public function testHasLinesEliminatedByOptimizer(): void
    {
        $this->assertSame(
            [4, 7],
            $this->file()->linesEliminatedByOptimizer(),
        );
    }

    private function file(): File
    {
        return new File(
            file(__DIR__ . '/../../fixture/source.php'),
            [4, 7],
        );
    }
}
