<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Plugin\Result;

class MatchResult implements ResultInterface
{
    /**
     * @var int
     */
    private $extentText;

    /**
     * @var string
     */
    private $elementName;

    /**
     * @var string
     */
    private $elementHandler;

    /**
     * @var string
     */
    private $elementText;

    /**
     * @var array
     */
    private $elementAttributes = [];

    /**
     * @param string $extentText
     * @param string $elementName
     * @param string $elementHandler
     */
    public function __construct(string $extentText, string $elementName, string $elementHandler)
    {
        $this->extentText = $extentText;
        $this->elementName = $elementName;
        $this->elementHandler = $elementHandler;
    }

    /**
     * @param string $elementText
     *
     * @return self
     */
    public function setElementText(string $elementText): self
    {
        $this->elementText = $elementText;

        return $this;
    }

    /**
     * @param array $elementAttributes
     *
     * @return self
     */
    public function setElementAttributes(array $elementAttributes): self
    {
        $this->elementAttributes = $elementAttributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        $result = [
            'extent' => strlen($this->extentText),
            'element' => [
                'name' => $this->elementName,
                'handler' => $this->elementHandler,
            ],
        ];

        if (null !== $this->elementText) {
            $result['element']['text'] = $this->elementText;
        }

        if (0 !== count($this->elementAttributes)) {
            $result['element']['attributes'] = $this->elementAttributes;
        }

        return $result;
    }
}
