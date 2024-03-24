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
use function is_dir;
use function is_file;
use function printf;
use function realpath;
use SebastianBergmann\FileIterator\Facade;
use SebastianBergmann\FOAL\Analyser;
use SebastianBergmann\FOAL\DiffRenderer;
use SebastianBergmann\FOAL\TextRenderer;

final readonly class Application
{
    private Analyser $analyser;

    public function __construct(Analyser $analyser)
    {
        $this->analyser = $analyser;
    }

    /**
     * @psalm-param list<non-empty-string> $argv
     */
    public function run(array $argv): int
    {
        $this->printVersion();

        try {
            $arguments = (new ArgumentsBuilder)->build($argv);
            // @codeCoverageIgnoreStart
        } catch (ArgumentsBuilderException $e) {
            print PHP_EOL . $e->getMessage() . PHP_EOL;

            return 1;
            // @codeCoverageIgnoreEnd
        }

        if ($arguments->version()) {
            return 0;
        }

        print PHP_EOL;

        if ($arguments->help()) {
            $this->help();

            return 0;
        }

        if ($arguments->arguments() === []) {
            $this->help();

            return 1;
        }

        $files = [];

        foreach ($arguments->arguments() as $argument) {
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

        $files = $this->analyser->analyse(array_values(array_unique($files)));

        if ($arguments->diff()) {
            $renderer = new DiffRenderer;
        } else {
            $renderer = new TextRenderer;
        }

        $first = true;

        foreach ($files as $file) {
            if (!$first) {
                print PHP_EOL;
            }

            print $renderer->render($file);

            $first = false;
        }

        return 0;
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

  --diff                           Display optimized-away lines as diff

  -h|--help                        Prints this usage information and exits
  --version                        Prints the version and exits

EOT;
    }
}
