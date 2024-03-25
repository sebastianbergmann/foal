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
    private bool $help;
    private bool $version;

    /**
     * @psalm-param list<non-empty-string> $arguments
     */
    public function __construct(array $arguments, bool $help, bool $version)
    {
        $this->arguments = $arguments;
        $this->help      = $help;
        $this->version   = $version;
    }

    /**
     * @psalm-return list<non-empty-string>
     */
    public function arguments(): array
    {
        return $this->arguments;
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
