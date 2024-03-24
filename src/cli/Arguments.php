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

final readonly class Arguments
{
    /**
     * @psalm-var ?non-empty-string
     */
    private ?string $file;
    private bool $help;
    private bool $version;

    /**
     * @psalm-param ?non-empty-string $file
     */
    public function __construct(?string $file, bool $help, bool $version)
    {
        $this->file    = $file;
        $this->help    = $help;
        $this->version = $version;
    }

    /**
     * @psalm-assert-if-true !null $this->file
     */
    public function hasFile(): bool
    {
        return $this->file !== null;
    }

    /**
     * @psalm-return non-empty-string
     *
     * @throws NoFileSpecifiedException
     */
    public function file(): string
    {
        if (!$this->hasFile()) {
            // @codeCoverageIgnoreStart
            throw new NoFileSpecifiedException;
            // @codeCoverageIgnoreEnd
        }

        return $this->file;
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
