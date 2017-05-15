<?php

/*
 * This file is part of the `src-run/cocoa-parsedown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Parsedown\Plugin;

interface PluginInlineInterface extends PluginInterface
{
    /**
     * @param array $excerpt
     *
     * @return null|array
     */
    public function invoke(array $excerpt);
}
