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
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileRenderer::class)]
#[UsesClass(File::class)]
#[Small]
final class FileRendererTest extends TestCase
{
    public function testRendersFileAsString(): void
    {
        $this->assertStringEqualsFile(
            __DIR__ . '/../expectations/source.txt',
            (new FileRenderer)->render($this->file()),
        );
    }

    private function file(): File
    {
        return new File(
            file(__DIR__ . '/../fixture/source.php'),
            [4, 7],
        );
    }
}
