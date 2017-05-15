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

class InlineIconPlugin implements PluginInlineInterface
{
    use PluginNamedTrait;
    use PluginResponseTrait;
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
     * @return array|null
     */
    public function invoke(array $excerpt) {
        if (1 !== preg_match('{^@(?<type>fa|ion):(?<name>[a-z\-]+)}', $excerpt['text'], $matches)) {
            return $this->responseNotMatch();
        }

        return $this->responseMatch(array_shift($matches), 'i', 'line', '', [
            'class' => sprintf('icon %s %s-%s', $matches['type'], $matches['type'], $matches['name']),
        ]);
    }
}
