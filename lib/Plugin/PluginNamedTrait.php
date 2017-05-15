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

trait PluginNamedTrait
{
    /**
     * @return string
     */
    public function name(): string
    {
        if (1 === preg_match('{(Inline|Block)(?<name>[A-Za-z]+)Plugin$}', get_called_class(), $matches)) {
            return $matches['name'];
        }

        throw new RuntimeException('Unable to automatically determine plugin name of "%s"', get_called_class());
    }
}
