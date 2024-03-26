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

use const PHP_EOL;
use function array_merge;
use function array_unique;
use function array_values;
use function assert;
use function count;
use function defined;
use function file_put_contents;
use function is_dir;
use function is_file;
use function printf;
use function realpath;
use SebastianBergmann\FileIterator\Facade;
use SebastianBergmann\FOAL\Analyser;
use SebastianBergmann\FOAL\Disassembler;
use SebastianBergmann\FOAL\TextRenderer;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class Application
{
    private Analyser $analyser;
    private Disassembler $disassembler;

    public function __construct(Analyser $analyser, Disassembler $disassembler)
    {
        $this->analyser     = $analyser;
        $this->disassembler = $disassembler;
    }

    /**
     * @psalm-param list<non-empty-string> $argv
     */
    public function run(array $argv): int
    {
        $this->printVersion();

        try {
            $configuration = (new ConfigurationBuilder)->build($argv);
            // @codeCoverageIgnoreStart
        } catch (ConfigurationBuilderException $e) {
            print PHP_EOL . $e->getMessage() . PHP_EOL;

            return 1;
            // @codeCoverageIgnoreEnd
        }

        if ($configuration->version()) {
            return 0;
        }

        print PHP_EOL;

        if ($configuration->help()) {
            $this->help();

            return 0;
        }

        if ($configuration->arguments() === []) {
            $this->help();

            return 1;
        }

        $files = [];

        foreach ($configuration->arguments() as $argument) {
            $candidate = realpath($argument);

            if ($candidate === false) {
                continue;
            }

            assert($candidate !== '');

            if (is_file($candidate)) {
                $files[] = $candidate;

                continue;
            }

            if (is_dir($candidate)) {
                $files = array_merge($files, (new Facade)->getFilesAsArray($candidate, '.php'));
            }
        }

        if (empty($files)) {
            print 'No files found to analyse' . PHP_EOL;

            return 1;
        }

        $files = array_values(array_unique($files));

        if ($configuration->hasPaths()) {
            return $this->handlePaths($files, $configuration->paths());
        }

        return $this->handleAnalysis($files);
    }

    private function printVersion(): void
    {
        printf(
            'foal %s by Sebastian Bergmann.' . PHP_EOL,
            Version::id(),
        );
    }

    private function help(): void
    {
        print <<<'EOT'
Usage:
  foal [options] <directory|file> ...

  --paths <directory>              Write execution paths before/after bytecode optimization to files in DOT format

  -h|--help                        Prints this usage information and exits
  --version                        Prints the version and exits

EOT;

        if (defined('__FOAL_PHAR__')) {
            print <<<'EOT'

  --manifest                       Prints Software Bill of Materials (SBOM) in plain-text format and exits
  --sbom                           Prints Software Bill of Materials (SBOM) in CycloneDX XML format and exits
  --composer-lock                  Prints the composer.lock file used to build the PHAR and exits

EOT;
        }
    }

    /**
     * @psalm-param non-empty-list<non-empty-string> $files
     * @psalm-param non-empty-string $target
     */
    private function handlePaths(array $files, string $target): int
    {
        if (count($files) !== 1) {
            print 'The --paths option only operates on a source single file' . PHP_EOL;

            return 1;
        }

        $unoptimizedFile = $target . '/unoptimized.dot';

        file_put_contents($unoptimizedFile, $this->disassembler->pathsBeforeOptimization($files[0]));

        printf(
            'Wrote execution paths for %s to %s' . PHP_EOL,
            $files[0],
            $unoptimizedFile,
        );

        $optimizedFile = $target . '/optimized.dot';

        file_put_contents($optimizedFile, $this->disassembler->pathsAfterOptimization($files[0]));

        printf(
            'Wrote optimized execution paths for %s to %s' . PHP_EOL,
            $files[0],
            $optimizedFile,
        );

        return 0;
    }

    /**
     * @psalm-param non-empty-list<non-empty-string> $files
     */
    private function handleAnalysis(array $files): int
    {
        $files = $this->analyser->analyse($files);

        $renderer = new TextRenderer;
        $first    = true;

        foreach ($files as $file) {
            if (!$first) {
                print PHP_EOL;
            }

            print $renderer->render($file);

            $first = false;
        }

        return 0;
    }
}
