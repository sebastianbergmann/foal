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

use SebastianBergmann\Version;
use Symfony\Component\Console\Application as AbstractApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @codeCoverageIgnore
 */
final class Application extends AbstractApplication
{
    public function __construct()
    {
        $version = new Version('1.0', \dirname(__DIR__, 2));

        parent::__construct('foal', $version->getVersion());
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();

        $inputDefinition->setArguments();

        return $inputDefinition;
    }

    public function doRun(InputInterface $input, OutputInterface $output): void
    {
        if (!$input->hasParameterOption('--quiet')) {
            $output->write(
                \sprintf(
                    "foal %s by Sebastian Bergmann.\n\n",
                    $this->getVersion()
                )
            );
        }

        if ($input->hasParameterOption('--version') ||
            $input->hasParameterOption('-V')) {
            exit;
        }

        if (!$input->getFirstArgument()) {
            $input = new ArrayInput(['--help']);
        }

        parent::doRun($input, $output);
    }

    protected function getCommandName(InputInterface $input)
    {
        return 'foal';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new Command;

        return $defaultCommands;
    }
}
