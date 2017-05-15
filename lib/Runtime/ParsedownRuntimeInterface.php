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
     * @param PluginInterface $plugin
     * @param bool            $before
     *
     * @return self
     */
    public function registerPlugin(PluginInterface $plugin, bool $before = false): self;
}
