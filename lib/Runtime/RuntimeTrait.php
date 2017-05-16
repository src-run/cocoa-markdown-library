<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Runtime;

use SR\Cocoa\Transformer\Markdown\Plugin\PluginBlockInterface;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginInlineInterface;
use SR\Cocoa\Transformer\Markdown\Plugin\PluginInterface;
use SR\Exception\Logic\BadMethodCallException;
use SR\Exception\Runtime\RuntimeException;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait RuntimeTrait
{
    /**
     * @var PluginInlineInterface[]
     */
    private $pluginsI = [];

    /**
     * @var PluginBlockInterface[]
     */
    private $pluginsB = [];

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (0 === strpos($name, 'b')) {
            return $this->callPluginBlk($name, $arguments);
        }

        if (0 === strpos($name, 'i')) {
            return $this->callPluginInl($name, $arguments);
        }

        throw new BadMethodCallException('Method "%s" cannot be called from magic __call method.', $name);
    }

    /**
     * @param string $string
     * @param bool   $block
     *
     * @return string
     */
    public function invokeRuntime(string $string, bool $block = true): string
    {
        return $block ? $this->text($string) : $this->line($string);
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $options = (new OptionsResolver())
            ->setDefaults([
                'breaks' => false,
                'escape-markup' => true,
                'link-urls' => true,
            ])
            ->setAllowedTypes('breaks', ['bool'])
            ->setAllowedTypes('escape-markup', ['bool'])
            ->setAllowedTypes('link-urls', ['bool'])
            ->resolve($options);

        $this->setBreaksEnabled($options['breaks']);
        $this->setMarkupEscaped($options['escape-markup']);
        $this->setUrlsLinked($options['link-urls']);
    }

    /**
     * @param PluginInterface $plugin
     * @param bool            $before
     */
    public function registerPlugin(PluginInterface $plugin, bool $before = false)
    {
        if (!$plugin instanceof PluginBlockInterface && !$plugin instanceof PluginInlineInterface) {
            throw new RuntimeException('Plugin type "%s" is not supported.', $plugin->type());
        }

        $this->registerInst($plugin);
        $this->registerType($plugin, $before);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return array|null
     */
    private function callPluginInl(string $name, array $arguments)
    {
        if (isset($this->pluginsI[$name = substr($name, 6)])) {
            return $this->pluginsI[$name]->invoke(...$arguments)->getResult();
        }

        return null;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return array|null
     */
    private function callPluginBlk(string $name, array $arguments)
    {
        if (isset($this->pluginsB[$name = substr($name, 5)])) {
            return $this->pluginsB[$name]->invoke(...$arguments)->getResult();
        }

        return null;
    }

    /**
     * @param PluginInterface $plugin
     */
    private function registerInst(PluginInterface $plugin)
    {
        $p = 'plugins'.ucwords(substr($plugin->type(), 0, 1));

        if (isset($this->{$p}[$plugin->name()])) {
            throw new RuntimeException('Plugin "%s" is already loaded.', $plugin->name());
        }

        $this->{$p}[$plugin->name()] = $plugin;
    }

    /**
     * @param PluginInterface $plugin
     * @param bool            $before
     */
    private function registerType(PluginInterface $plugin, bool $before)
    {
        $p = ucwords($plugin->type()).'Types';
        $t = isset($this->{$p}[$plugin->marker()]) ? $this->{$p}[$plugin->marker()] : [];

        $t[] = $plugin->name();
        if (true === $before) {
            array_unshift($t, $plugin->name());
        }

        $this->{$p}[$plugin->marker()] = $t;

        if ($plugin->type()[0] === 'i') {
            $this->{$plugin->type().'MarkerList'} .= $plugin->marker();
        }
    }
}
