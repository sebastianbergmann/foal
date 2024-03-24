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

use PHPUnit\Framework\Attributes\Medium;
use function file;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(DiffRenderer::class)]
#[Medium]
#[TestDox('DiffRenderer')]
final class DiffRendererTest extends TestCase
{
    public function testRendersFileAsDiff(): void
    {
        $this->assertStringMatchesFormatFile(
            __DIR__ . '/../expectations/source.diff',
            (new DiffRenderer)->render($this->file()),
        );
    }

    private function file(): File
    {
        return new File(
            __DIR__ . '/../fixture/source.php',
            file(__DIR__ . '/../fixture/source.php'),
            [4, 7],
        );
    }
}
