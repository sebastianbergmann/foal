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

use function array_values;
use function count;
use Countable;
use IteratorAggregate;

/**
 * @template-implements IteratorAggregate<int, File>
 *
 * @psalm-immutable
 *
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class FileCollection implements Countable, IteratorAggregate
{
    /**
     * @psalm-var list<File>
     */
    private array $files;

    public static function from(File ...$files): self
    {
        return new self(array_values($files));
    }

    /**
     * @psalm-param list<File> $files
     */
    private function __construct(array $files)
    {
        $this->files = $files;
    }

    /**
     * @psalm-return list<File>
     */
    public function asArray(): array
    {
        return $this->files;
    }

    public function getIterator(): FileCollectionIterator
    {
        return new FileCollectionIterator($this);
    }

    public function count(): int
    {
        return count($this->files);
    }

    public function isEmpty(): bool
    {
        return empty($this->files);
    }
}
