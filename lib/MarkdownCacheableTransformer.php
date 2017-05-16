<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown;

use SR\Cocoa\Transformer\AbstractCacheableTransformer;

class MarkdownCacheableTransformer extends AbstractCacheableTransformer
{
    use MarkdownTransformerTrait;
}
