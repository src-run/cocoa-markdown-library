<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Tests\Fixtures\Plugin;

use SR\Cocoa\Transformer\Markdown\Plugin\PluginInterface;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginNamedTrait;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginTypedTrait;
use SR\Cocoa\Transformer\Markdown\Plugin\Result\MatchResult;
use SR\Cocoa\Transformer\Markdown\Plugin\Result\ResultInterface;

class UnknownPlugin implements PluginInterface
{
    use PluginNamedTrait;
    use PluginTypedTrait;

    /**
     * @return string
     */
    public function marker(): string
    {
        return '+';
    }

    /**
     * @param array $excerpt
     *
     * @return ResultInterface
     */
    public function invoke(array $excerpt): ResultInterface
    {
        return new MatchResult('text', 'i', 'line');
    }
}
