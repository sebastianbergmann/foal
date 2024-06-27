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
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TextRenderer::class)]
#[UsesClass(File::class)]
#[Small]
#[TestDox('TextRenderer')]
final class TextRendererTest extends TestCase
{
    public function testRendersFileAsString(): void
    {
        $this->assertStringMatchesFormatFile(
            __DIR__ . '/../expectations/source.txt',
            (new TextRenderer)->render($this->file()),
        );
    }

    private function file(): File
    {
        $sourceLines = file(__DIR__ . '/../fixture/source.php');

        assert($sourceLines !== false);

        return new File(
            __DIR__ . '/../fixture/source.php',
            $sourceLines,
            [4, 7],
        );
    }
}
