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

class InlineNewlinePlugin implements PluginInlineInterface
{
    use PluginNamedTrait;
    use PluginResponseTrait;
    use PluginTypedTrait;

    /**
     * @return string
     */
    public function marker(): string
    {
        return '\\';
    }

    /**
     * @param array $excerpt
     *
     * @return array|null
     */
    public function invoke(array $excerpt) {
        if (1 !== preg_match('{(?<escape>\\\)?(?<newline>\\\n)}', $excerpt['text'], $matches)) {
            return $this->responseNotMatch();
        }

        if ($matches['escape']) {
            return $this->responseNotMatch();
        }

        return $this->responseMatch(array_shift($matches), 'br', 'line');
    }
}
