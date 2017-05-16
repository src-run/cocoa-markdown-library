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

use SR\Cocoa\Transformer\Markdown\Plugin\PluginBlockInterface;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginNamedTrait;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginTypedTrait;
use SR\Cocoa\Transformer\Markdown\Plugin\Result\MatchResult;
use SR\Cocoa\Transformer\Markdown\Plugin\Result\ResultInterface;

class BlockUnknownPlugin implements PluginBlockInterface
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
     * @param array $block
     *
     * @return ResultInterface
     */
    public function invoke(array $excerpt, array $block): ResultInterface
    {
        return new MatchResult('text', 'i', 'line');
    }

    /**
     * @param array $excerpt
     * @param array $block
     *
     * @return ResultInterface
     */
    public function invokeContinued(array $excerpt, array $block): ResultInterface
    {
        return new MatchResult('text', 'i', 'line');
    }
}
