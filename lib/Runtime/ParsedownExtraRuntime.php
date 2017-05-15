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


use SR\Cocoa\Transformer\Parsedown\Plugin\InlineIconPlugin;
use SR\Cocoa\Transformer\Parsedown\Plugin\InlineNewlinePlugin;

class ParsedownExtraRuntime extends \ParsedownExtra implements ParsedownRuntimeInterface
{
    use ParsedownRuntimeTrait;

    public function __construct(array $options = [])
    {
        parent::__construct();

        $this->setOptions($options);
        $this->registerPlugin(new InlineIconPlugin());
        $this->registerPlugin(new InlineNewlinePlugin(), true);
    }
}
