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

class InlinePullQuotePlugin implements PluginInlineInterface
{
    use PluginNamedTrait;
    use PluginTypedTrait;

    /**
     * @return string
     */
    public function marker(): string
    {
        return '{';
    }

    /**
     * @param array $excerpt
     *
     * @return ResultInterface
     */
    public function invoke(array $excerpt): ResultInterface
    {
        if (1 !== preg_match('{^\{(?<quote>[^\}\{]+)\}}', $excerpt['text'], $matches)) {
            return new EmptyResult();
        }

        return (new MatchResult(array_shift($matches), 'span', 'line'))
            ->setElementText($matches['quote'])
            ->setElementAttributes([
                'data-pull-quote' => $this->escapeAttribute($matches['quote']),
            ]);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function escapeAttribute(string $string): string
    {
        return htmlspecialchars(trim(preg_replace('/\s+/', ' ', sprintf('"%s"', $string))), ENT_QUOTES | ENT_HTML5);
    }
}
