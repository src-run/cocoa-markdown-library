<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Tests;

use PHPUnit\Framework\TestCase;
use SR\Cocoa\Transformer\Markdown\Runtime\RuntimeExtended;
use SR\Cocoa\Transformer\Markdown\Runtime\RuntimeNormal;
use SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin\BlockUnknownPlugin;
use SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin\InlineUnknownPlugin;
use SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin\UnknownPlugin;

class RuntimeTest extends TestCase
{
    public function testPluginRegistration()
    {
        $runtime = $this->getRuntimeNormalInstance();
        $runtime->registerPlugin(new BlockUnknownPlugin());
        $runtime->registerPlugin(new InlineUnknownPlugin());

        $c = new \ReflectionObject($runtime);
        $pluginsI = $c->getProperty('pluginsI');
        $pluginsI->setAccessible(true);

        $pluginsB = $c->getProperty('pluginsB');
        $pluginsB->setAccessible(true);

        $this->assertCount(1, $pluginsI->getValue($runtime));
        $this->assertCount(1, $pluginsB->getValue($runtime));
    }

    /**
     * @expectedException \SR\Exception\Runtime\RuntimeException
     * @expectedExceptionMessageRegExp {Unable to automatically determine plugin type of ".+"}
     */
    public function testPluginRegistrationThrows()
    {
        $runtime = $this->getRuntimeNormalInstance();
        $runtime->registerPlugin(new UnknownPlugin());
    }

    /**
     * @expectedException \SR\Exception\Logic\BadMethodCallException
     * @expectedExceptionMessageRegExp {Method ".+" cannot be called from magic __call method.}
     */
    public function testCall()
    {
        $runtime = $this->getRuntimeNormalInstance();
        $runtime->registerPlugin(new BlockUnknownPlugin());
        $runtime->registerPlugin(new InlineUnknownPlugin());

        $this->assertInternalType('array', $runtime->blockunknown([], []));
        $this->assertInternalType('array', $runtime->inlineunknown([]));

        $runtime->notCallable();
    }

    public function testCallDoesNotExist()
    {
        $runtime = $this->getRuntimeNormalInstance();

        $this->assertNull($runtime->blockunknown([], []));
        $this->assertNull($runtime->inlineunknown([]));
    }

    /**
     * @expectedException \SR\Exception\Runtime\RuntimeException
     * @expectedExceptionMessageRegExp {Plugin ".+" is already loaded.}
     */
    public function testPluginExists()
    {
        $runtime = $this->getRuntimeNormalInstance();
        $runtime->registerPlugin(new BlockUnknownPlugin());
        $runtime->registerPlugin(new BlockUnknownPlugin());
    }

    private function getRuntimeExtendedInstance(): RuntimeExtended
    {
        return new RuntimeExtended();
    }

    private function getRuntimeNormalInstance(): RuntimeNormal
    {
        return new RuntimeNormal();
    }
}
