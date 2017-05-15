<?php

/*
 * This file is part of the `src-run/cocoa-parsedown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown;

class ParsedownExtras extends \ParsedownExtra
{
    public function __construct()
    {
        parent::__construct();

        $this->InlineTypes['@'] = ['Icons'];
        $this->inlineMarkerList .= '@';

        $this->InlineTypes['\\'][] = 'Newline';
        array_unshift($this->InlineTypes['\\'], 'Newline');
    }

    /**
     * @param array $excerpt
     *
     * @return null|array
     */
    protected function inlineIcons(array $excerpt)
    {
        if (1 !== preg_match('{^@(?<type>fa|ion):(?<name>[a-z\-]+)}', $excerpt['text'], $matches)) {
            return null;
        }

        return [
            'extent' => strlen(array_shift($matches)),
            'element' => [
                'name' => 'i',
                'handler' => 'line',
                'text' => '',
                'attributes' => [
                    'class' => sprintf('icon %s %s-%s', $matches['type'], $matches['type'], $matches['name']),
                ],
            ],
        ];
    }

    /**
     * @param array $excerpt
     *
     * @return null|array
     */
    protected function inlineNewline(array $excerpt)
    {
        if (1 !== preg_match('{(?<escape>\\\)?(?<newline>\\\n)}', $excerpt['text'], $matches)) {
            return null;
        }

        if ($matches['escape']) {
            return null;
        }

        return [
            'extent' => strlen(array_shift($matches)),
            'element' => [
                'name' => 'br',
                'handler' => 'line',
            ],
        ];
    }
}
