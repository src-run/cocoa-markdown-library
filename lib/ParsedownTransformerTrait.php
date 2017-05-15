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

use SR\Cocoa\Transformer\Parsedown\Runtime\ParsedownExtraRuntime;
use SR\Cocoa\Transformer\Parsedown\Runtime\ParsedownNormalRuntime;
use SR\Cocoa\Transformer\Parsedown\Runtime\ParsedownRuntimeInterface;
use SR\Exception\Runtime\RuntimeException;

trait ParsedownTransformerTrait
{
    /**
     * @var bool
     */
    private $extra = true;

    /**
     * @var ParsedownRuntimeInterface
     */
    private $runtime;

    /**
     * @param bool $enable
     *
     * @return ParsedownTransformerTrait
     */
    public function setExtra(bool $enable): self
    {
        $this->extra = $enable;

        return $this;
    }

    /**
     * @param ParsedownRuntimeInterface $parsedown
     *
     * @return ParsedownTransformerTrait
     */
    public function setRuntime(ParsedownRuntimeInterface $parsedown): self
    {
        $this->runtime = $parsedown;

        return $this;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function runTransformation(string $string): string
    {
        return $this->getParsedownTransformer()->invokeRuntime($string);
    }

    /**
     * @return ParsedownRuntimeInterface
     */
    private function getParsedownTransformer(): ParsedownRuntimeInterface
    {
        if ($this->runtime instanceof \Parsedown) {
            if ($this->extra) {
                throw new RuntimeException('A custom parsedown instance cannot be used when the extras flag is also enabled.');
            }

            return clone $this->runtime;
        }

        return $this->extra ? new ParsedownExtraRuntime() : new ParsedownNormalRuntime();
    }
}
