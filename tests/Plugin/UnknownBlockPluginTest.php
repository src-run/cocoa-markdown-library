<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Tests\Plugin;

use PHPUnit\Framework\TestCase;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginBlockInterface;
use SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin\BlockUnknownPlugin;

class UnknownBlockPluginTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(PluginBlockInterface::class, $this->getUnknownPluginInstance());
    }

    public function testType()
    {
        $this->assertSame('block', $this->getUnknownPluginInstance()->type());
    }

    public function testName()
    {
        $this->assertSame('unknown', $this->getUnknownPluginInstance()->name());
    }

    /**
     * @return PluginBlockInterface
     */
    private function getUnknownPluginInstance(): PluginBlockInterface
    {
        return new BlockUnknownPlugin();
    }
}
