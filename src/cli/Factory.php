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
use SebastianBergmann\FOAL\VldDisassembler;
use SebastianBergmann\FOAL\VldParser;

/**
 * @internal This class is not covered by the backward compatibility promise for FOAL
 */
final readonly class Factory
{
    public function createApplication(): Application
    {
        return new Application(
            new Analyser($this->disassembler()),
            $this->disassembler(),
        );
    }

    private function disassembler(): VldDisassembler
    {
        return new VldDisassembler(
            new VldParser,
        );
    }
}
