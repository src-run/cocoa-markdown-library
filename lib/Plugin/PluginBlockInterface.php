<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Plugin;

use SR\Cocoa\Transformer\Markdown\Plugin\Result\ResultInterface;

interface PluginBlockInterface extends PluginInterface
{
    /**
     * @param array $excerpt
     * @param array $block
     *
     * @return ResultInterface
     */
    public function invoke(array $excerpt, array $block): ResultInterface;

    /**
     * @param array $excerpt
     * @param array $block
     *
     * @return ResultInterface
     */
    public function invokeContinued(array $excerpt, array $block): ResultInterface;
}
