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

use SR\Cocoa\Transformer\Parsedown\Plugin\InlineIconPlugin;
use SR\Cocoa\Transformer\Parsedown\Plugin\InlineNewlinePlugin;
use SR\Cocoa\Transformer\Parsedown\Runtime\ParsedownRuntime;
use SR\Exception\Runtime\RuntimeException;

trait ParsedownTransformerTrait
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
        return $this->setupRuntime($this->getParsedownTransformer())->text($string);
    }

    private function setupRuntime(\Parsedown $runtime): \Parsedown
    {
        $runtime->setMarkupEscaped($this->markupEscaping);
        $runtime->setBreaksEnabled($this->autoLineBreaking);
        $runtime->setUrlsLinked($this->urlLinking);

        if ($runtime instanceof ParsedownRuntime) {
            $runtime->registerPlugin(new InlineIconPlugin());
            $runtime->registerPlugin(new InlineNewlinePlugin(), true);
        }

        return $runtime;
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

        return $this->enableExtras ? new ParsedownRuntime() : new \Parsedown();
    }
}
