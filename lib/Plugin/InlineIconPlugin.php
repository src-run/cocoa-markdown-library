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

use SR\Cocoa\Transformer\Markdown\Plugin\Result\EmptyResult;
use SR\Cocoa\Transformer\Markdown\Plugin\Result\MatchResult;
use SR\Cocoa\Transformer\Markdown\Plugin\Result\ResultInterface;

class InlineIconPlugin implements PluginInlineInterface
{
    use PluginNamedTrait;
    use PluginTypedTrait;

    /**
     * @return string
     */
    public function marker(): string
    {
        return '@';
    }

    /**
     * @param array $excerpt
     *
     * @return ResultInterface
     */
    public function invoke(array $excerpt): ResultInterface
    {
        if (1 !== preg_match('{^@(?<type>fa|ion):(?<name>[a-z\-]+)}', $excerpt['text'], $matches)) {
            return new EmptyResult();
        }

        return (new MatchResult(array_shift($matches), 'i', 'line'))
            ->setElementText('')
            ->setElementAttributes([
                'class' => sprintf('icon %s %s-%s', $matches['type'], $matches['type'], $matches['name']),
            ]);
    }
}
