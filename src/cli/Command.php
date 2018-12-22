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

use SebastianBergmann\FOAL\Analyser;
use Symfony\Component\Console\Command\Command as AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
final class Command extends AbstractCommand
{
    protected function configure(): void
    {
        $this->setName('foal');

        $this->addArgument('filename', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->ensureOpCacheIsAvailable($output);
        $this->ensureVldIsAvailable($output);

        $php = new Analyser;

        $filename = $input->getArgument('filename');
        $lines    = $php->linesEliminatedByOptimizer($filename);

        if (empty($lines)) {
            $output->writeln('The OpCache optimizer did not eliminate any sourcecode lines.');

            exit;
        }

        $output->writeln('The OpCache optimizer eliminated the following sourcecode lines:');
        $output->writeln('');

        $source = \file($filename);

        foreach ($lines as $line) {
            $output->writeln(
                \sprintf(
                    '%-6d %s',
                    $line,
                    \rtrim($source[$line - 1])
                )
            );
        }
    }

    private function ensureOpCacheIsAvailable(OutputInterface $output): void
    {
        if (!\extension_loaded('Zend OPcache')) {
            $output->writeln(\PHP_BINARY . ' does not have OpCache enabled.');

            exit(1);
        }
    }

    private function ensureVldIsAvailable(OutputInterface $output): void
    {
        if (!\extension_loaded('vld')) {
            $output->writeln(\PHP_BINARY . ' does not have VLD enabled.');

            exit(1);
        }
    }
}
