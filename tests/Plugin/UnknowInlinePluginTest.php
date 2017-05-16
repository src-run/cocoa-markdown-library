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
use SR\Cocoa\Transformer\Markdown\Plugin\PluginInlineInterface;
use SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin\InlineUnknownPlugin;

class UnknownInlinePluginTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(PluginInlineInterface::class, $this->getUnknownPluginInstance());
    }

    public function testType()
    {
        $this->assertSame('inline', $this->getUnknownPluginInstance()->type());
    }

    public function testName()
    {
        $this->assertSame('unknown', $this->getUnknownPluginInstance()->name());
    }

    /**
     * @return PluginInlineInterface
     */
    private function getUnknownPluginInstance(): PluginInlineInterface
    {
        return new InlineUnknownPlugin();
    }
}
