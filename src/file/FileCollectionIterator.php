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

use Iterator;

/**
 * @template-implements Iterator<int, File>
 */
final class FileCollectionIterator implements Iterator
{
    /**
     * @psalm-var list<File>
     */
    private readonly array $files;
    private int $position = 0;

    public function __construct(FileCollection $collection)
    {
        $this->files = $collection->asArray();
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->files[$this->position]);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function current(): File
    {
        return $this->files[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }
}
