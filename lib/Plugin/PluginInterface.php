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

interface PluginInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return string
     */
    public function marker(): string;
}
