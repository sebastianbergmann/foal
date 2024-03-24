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
use function is_file;
use function printf;
use SebastianBergmann\FOAL\Analyser;
use SebastianBergmann\FOAL\FileRenderer;

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

        if (!$arguments->hasFile()) {
            $this->help();

            return 1;
        }

        if (!is_file($arguments->file())) {
            printf(
                'Cannot read file %s' . PHP_EOL,
                $arguments->file(),
            );

            return 1;
        }

        $file = $this->analyser->analyse($arguments->file());

        $renderer = new FileRenderer;

        print $renderer->render($file);

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
  foal [options] <file>

  -h|--help                        Prints this usage information and exits
  --version                        Prints the version and exits

EOT;
    }
}
