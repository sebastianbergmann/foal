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
use function exec;
use function extension_loaded;
use function file_get_contents;
use function implode;
use function is_string;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class VldDisassembler implements Disassembler
{
    private const string VLD_OPTIONS_COMMON      = '-d vld.active=1 -d vld.execute=0 -d vld.verbosity=0';
    private const string VLD_OPTIONS_BYTECODE    = self::VLD_OPTIONS_COMMON . ' -d vld.format=1 -d vld.col_sep=\';\'';
    private const string VLD_OPTIONS_PATHS       = self::VLD_OPTIONS_COMMON . ' -d vld.save_paths=1 -d vld.save_dir=/tmp';
    private const string OPCACHE_OPTIONS_ENABLE  = '-d opcache.enable=1 -d opcache.enable_cli=1 -d opcache.optimization_level=-1';
    private const string OPCACHE_OPTIONS_DISABLE = '-d opcache.enable=0 -d opcache.enable_cli=0';
    private VldParser $parser;

    /**
     * @throws OpcacheNotLoadedException
     * @throws VldNotLoadedException
     */
    public function __construct(VldParser $parser)
    {
        $this->ensureOpCacheIsAvailable();
        $this->ensureVldIsAvailable();

        $this->parser = $parser;
    }

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function linesWithOpcodesBeforeOptimization(string $file): array
    {
        return $this->parser->linesWithOpcodes(
            $this->execute(
                PHP_BINARY . ' ' . self::OPCACHE_OPTIONS_DISABLE . ' ' . self::VLD_OPTIONS_BYTECODE . ' ' . $file,
            ),
        );
    }

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function linesWithOpcodesAfterOptimization(string $file): array
    {
        return $this->parser->linesWithOpcodes(
            $this->execute(
                PHP_BINARY . ' ' . self::OPCACHE_OPTIONS_ENABLE . ' ' . self::VLD_OPTIONS_BYTECODE . ' ' . $file,
            ),
        );
    }

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return non-empty-string
     */
    public function pathsBeforeOptimization(string $file): string
    {
        $this->execute(
            PHP_BINARY . ' ' . self::OPCACHE_OPTIONS_DISABLE . ' ' . self::VLD_OPTIONS_PATHS . ' ' . $file,
        );

        $buffer = file_get_contents('/tmp/paths.dot');

        assert(is_string($buffer) && $buffer !== '');

        return $buffer;
    }

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return non-empty-string
     */
    public function pathsAfterOptimization(string $file): string
    {
        $this->execute(
            PHP_BINARY . ' ' . self::OPCACHE_OPTIONS_ENABLE . ' ' . self::VLD_OPTIONS_PATHS . ' ' . $file,
        );

        $buffer = file_get_contents('/tmp/paths.dot');

        assert(is_string($buffer) && $buffer !== '');

        return $buffer;
    }

    /**
     * @throws OpcacheNotLoadedException
     */
    private function ensureOpCacheIsAvailable(): void
    {
        if (!extension_loaded('Zend OPcache')) {
            // @codeCoverageIgnoreStart
            throw new OpcacheNotLoadedException;
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @throws VldNotLoadedException
     */
    private function ensureVldIsAvailable(): void
    {
        if (!extension_loaded('vld')) {
            // @codeCoverageIgnoreStart
            throw new VldNotLoadedException;
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @psalm-return list<string>
     */
    private function execute(string $command): array
    {
        exec($command . ' 2>&1', $output, $returnValue);

        if ($returnValue !== 0) {
            // @codeCoverageIgnoreStart
            throw new ProcessException(implode("\r\n", $output));
            // @codeCoverageIgnoreEnd
        }

        return $output;
    }
}
