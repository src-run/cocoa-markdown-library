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

use SR\Exception\Runtime\RuntimeException;

trait PluginTypedTrait
{
    /**
     * @return string
     */
    public function type(): string
    {
        if (1 === preg_match('{(?<type>Block|Inline)[^\\\]+Plugin$}', get_called_class(), $matches)) {
            return strtolower($matches['type']);
        }

        throw new RuntimeException('Unable to automatically determine plugin type of "%s"', get_called_class());
    }
}
