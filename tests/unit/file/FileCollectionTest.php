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
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileCollection::class)]
#[CoversClass(FileCollectionIterator::class)]
#[UsesClass(File::class)]
#[Small]
#[TestDox('FileCollection')]
final class FileCollectionTest extends TestCase
{
    #[TestDox('Can be created from list of File objects')]
    public function testCanBeCreatedFromListOfObjects(): void
    {
        $file = $this->file();

        $collection = FileCollection::from($file);

        $this->assertSame([$file], $collection->asArray());
    }

    public function testCanBeCounted(): void
    {
        $collection = FileCollection::from($this->file());

        $this->assertCount(1, $collection);
        $this->assertFalse($collection->isEmpty());
    }

    public function testCanBeIterated(): void
    {
        $file = $this->file();

        $collection = FileCollection::from($file);

        foreach ($collection as $key => $value) {
            $this->assertSame(0, $key);
            $this->assertSame($file, $value);
        }
    }

    private function file(): File
    {
        return new File(
            file(__DIR__ . '/../../fixture/source.php'),
            [4, 7],
        );
    }
}
