<?php declare(strict_types=1);
/*
 * This file is part of FOAL.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\FOAL\CLI;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class Arguments
{
    /**
     * @psalm-var list<non-empty-string>
     */
    private array $arguments;

    /**
     * @psalm-var ?non-empty-string
     */
    private ?string $paths;
    private bool $help;
    private bool $version;

    /**
     * @psalm-param list<non-empty-string> $arguments
     * @psalm-param ?non-empty-string $paths
     */
    public function __construct(array $arguments, ?string $paths, bool $help, bool $version)
    {
        $this->arguments = $arguments;
        $this->help      = $help;
        $this->paths     = $paths;
        $this->version   = $version;
    }

    /**
     * @psalm-return list<non-empty-string>
     */
    public function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * @psalm-assert-if-true !null $this->paths
     */
    public function hasPaths(): bool
    {
        return $this->paths !== null;
    }

    /**
     * @psalm-return non-empty-string
     *
     * @throws PathsNotConfiguredException
     */
    public function paths(): string
    {
        if ($this->paths === null) {
            // @codeCoverageIgnoreStart
            throw new PathsNotConfiguredException;
            // @codeCoverageIgnoreEnd
        }

        return $this->paths;
    }

    public function help(): bool
    {
        return $this->help;
    }

    public function version(): bool
    {
        return $this->version;
    }
}
