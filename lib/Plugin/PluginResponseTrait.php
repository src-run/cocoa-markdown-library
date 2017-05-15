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

trait PluginResponseTrait
{
    /**
     * @param string      $extentTest
     * @param string      $name
     * @param string      $handler
     * @param string|null $text
     * @param array       $attributes
     *
     * @return array
     */
    private function responseMatch(string $extentTest, string $name, string $handler, string $text = null, array $attributes = []): array
    {
        $response = [
            'extent' => strlen($extentTest),
            'element' => [
                'name' => $name,
                'handler' => $handler,
            ],
        ];

        if (null !== $text) {
            $response['element']['text'] = $text;
        }

        if (0 !== count($attributes)) {
            $response['element']['attributes'] = $attributes;
        }

        return $response;
    }

    /**
     * @return null
     */
    private function responseNotMatch()
    {
        return null;
    }
}
