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

use SR\Cocoa\Transformer\AbstractCacheableTransformer;
use SR\Exception\Runtime\RuntimeException;

class ParsedownTransformer extends AbstractCacheableTransformer
{
    /**
     * @var bool
     */
    private $enableExtras = true;

    /**
     * @var bool
     */
    private $markupEscaping = true;

    /**
     * @var bool
     */
    private $autoLineBreaking = false;

    /**
     * @var bool
     */
    private $urlLinking = true;

    /**
     * @var \Parsedown|null
     */
    private $customParsedown;

    /**
     * @param bool $extras
     *
     * @return self
     */
    public function setEnableExtras(bool $extras): self
    {
        $this->enableExtras = $extras;

        return $this;
    }

    /**
     * @param bool $markupEscaping
     *
     * @return self
     */
    public function setMarkupEscaping(bool $markupEscaping): self
    {
        $this->markupEscaping = $markupEscaping;

        return $this;
    }

    /**
     * @param bool $autoLineBreaking
     *
     * @return self
     */
    public function setAutoLineBreaking(bool $autoLineBreaking): self
    {
        $this->autoLineBreaking = $autoLineBreaking;

        return $this;
    }

    /**
     * @param bool $urlLinking
     *
     * @return self
     */
    public function setUrlLinking(bool $urlLinking): self
    {
        $this->urlLinking = $urlLinking;

        return $this;
    }

    /**
     * @param \Parsedown $parsedown
     *
     * @return self
     */
    public function setCustomParsedown(\Parsedown $parsedown): self
    {
        $this->setEnableExtras(false);
        $this->customParsedown = $parsedown;

        return $this;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function runTransformation(string $string): string
    {
        $transformer = $this->getParsedownTransformer();
        $transformer->setMarkupEscaped($this->markupEscaping);
        $transformer->setBreaksEnabled($this->autoLineBreaking);
        $transformer->setUrlsLinked($this->urlLinking);

        return $transformer->text($string);
    }

    /**
     * @return \Parsedown
     */
    private function getParsedownTransformer(): \Parsedown
    {
        if ($this->customParsedown instanceof \Parsedown) {
            if ($this->enableExtras) {
                throw new RuntimeException('A custom parsedown instance cannot be used when the extras flag is also enabled.');
            }

            return clone $this->customParsedown;
        }

        return $this->enableExtras ? new ParsedownExtras() : new \Parsedown();
    }
}
