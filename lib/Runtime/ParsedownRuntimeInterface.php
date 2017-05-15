<?php

/*
 * This file is part of the `src-run/cocoa-parsedown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Parsedown\Runtime;

use SR\Cocoa\Transformer\Parsedown\Plugin\PluginInterface;

interface ParsedownRuntimeInterface
{
    /**
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * @param PluginInterface $plugin
     * @param bool            $before
     */
    public function registerPlugin(PluginInterface $plugin, bool $before = false);

    /**
     * @param string $string
     * @param bool   $block
     *
     * @return string
     */
    public function invokeRuntime(string $string, bool $block = true): string;
}
