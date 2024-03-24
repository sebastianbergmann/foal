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

use function exec;
use function extension_loaded;
use function implode;

final readonly class VldLinesWithOpcodesFinder implements LinesWithOpcodesFinder
{
    private const string PRINT_OPCODES_OPTIONS        = '-d vld.active=1 -d vld.execute=0 -d vld.verbosity=0 -d vld.format=1 -d vld.col_sep=\';\'';
    private const string ENABLE_OPTIMIZATION_OPTIONS  = '-d opcache.enable=1 -d opcache.enable_cli=1 -d opcache.optimization_level=-1';
    private const string DISABLE_OPTIMIZATION_OPTIONS = '-d opcache.enable=0 -d opcache.enable_cli=0';
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
    public function beforeOptimization(string $file): array
    {
        return $this->parser->linesWithOpcodes(
            $this->execute(
                PHP_BINARY . ' ' . self::DISABLE_OPTIMIZATION_OPTIONS . ' ' . self::PRINT_OPCODES_OPTIONS . ' ' . $file . ' 2>&1',
            ),
        );
    }

    /**
     * @psalm-param non-empty-string $file
     *
     * @psalm-return list<int>
     */
    public function afterOptimization(string $file): array
    {
        return $this->parser->linesWithOpcodes(
            $this->execute(
                PHP_BINARY . ' ' . self::ENABLE_OPTIMIZATION_OPTIONS . ' ' . self::PRINT_OPCODES_OPTIONS . ' ' . $file . ' 2>&1',
            ),
        );
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
        exec($command, $output, $returnValue);

        if ($returnValue !== 0) {
            // @codeCoverageIgnoreStart
            throw new ProcessException(implode("\r\n", $output));
            // @codeCoverageIgnoreEnd
        }

        return $output;
    }
}
