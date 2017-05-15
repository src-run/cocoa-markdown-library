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

class ParsedownNormalRuntime extends \Parsedown implements ParsedownRuntimeInterface
{
    use ParsedownRuntimeTrait;

    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }
}
