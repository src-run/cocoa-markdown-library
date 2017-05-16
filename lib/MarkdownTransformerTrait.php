<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown;

use SR\Cocoa\Transformer\Markdown\Runtime\RuntimeExtended;
use SR\Cocoa\Transformer\Markdown\Runtime\RuntimeInterface;

trait MarkdownTransformerTrait
{
    /**
     * @var bool
     */
    private $block = true;

    /**
     * @var RuntimeInterface
     */
    private $runtime;

    /**
     * @param bool $block
     *
     * @return MarkdownTransformerTrait
     */
    public function setBlock(bool $block): self
    {
        $this->block = $block;

        return $this;
    }

    /**
     * @param RuntimeInterface $parsedown
     *
     * @return MarkdownTransformerTrait
     */
    public function setRuntime(RuntimeInterface $parsedown): self
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
        return $this->getRuntime()->invokeRuntime($string, $this->block);
    }

    /**
     * @return RuntimeInterface
     */
    private function getRuntime(): RuntimeInterface
    {
        return $this->runtime instanceof RuntimeInterface ? $this->runtime : new RuntimeExtended();
    }
}
