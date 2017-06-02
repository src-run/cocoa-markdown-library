<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Runtime;

use SR\Cocoa\Transformer\Markdown\Plugin\InlineIconPlugin;
use SR\Cocoa\Transformer\Markdown\Plugin\InlineNewlinePlugin;
use SR\Cocoa\Transformer\Markdown\Plugin\InlinePullQuotePlugin;

class RuntimeExtended extends \ParsedownExtra implements RuntimeInterface
{
    use RuntimeTrait;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct();

        $this->setOptions($options);
        $this->registerPlugin(new InlineIconPlugin());
        $this->registerPlugin(new InlineNewlinePlugin(), true);
        $this->registerPlugin(new InlinePullQuotePlugin());
    }
}
