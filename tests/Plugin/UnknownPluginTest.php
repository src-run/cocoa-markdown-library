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
use SR\Cocoa\Transformer\Markdown\Plugin\PluginInterface;
use SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin\UnknownPlugin;

class UnknownPluginTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(PluginInterface::class, $this->getUnknownPluginInstance());
    }

    /**
     * @expectedException \SR\Exception\Runtime\RuntimeException
     * @expectedExceptionMessageRegExp {Unable to automatically determine plugin type of ".+"}
     */
    public function testTypeThrowsException()
    {
        $this->getUnknownPluginInstance()->type();
    }

    /**
     * @expectedException \SR\Exception\Runtime\RuntimeException
     * @expectedExceptionMessageRegExp {Unable to automatically determine plugin name of ".+"}
     */
    public function testNameThrowsException()
    {
        $this->getUnknownPluginInstance()->name();
    }

    /**
     * @return PluginInterface
     */
    private function getUnknownPluginInstance(): PluginInterface
    {
        return new UnknownPlugin();
    }
}
