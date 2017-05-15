<?php

/*
 * This file is part of the `src-run/cocoa-parsedown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Parsedown;

use SR\Cocoa\Transformer\AbstractTransformer;

class ParsedownTransformer extends AbstractTransformer
{
    use ParsedownTransformerTrait;

    /**
     * @param string $string
     *
     * @return string
     */
    public function transform(string $string): string
    {
        return $this->runTransformation($string);
    }
}
