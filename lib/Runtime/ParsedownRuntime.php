<?php

/*
 * This file is part of the `src-run/cocoa-parsedown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Parsedown\Runtime;

use SR\Cocoa\Transformer\Parsedown\Plugin\PluginBlockInterface;
use SR\Cocoa\Transformer\Parsedown\Plugin\PluginInlineInterface;
use SR\Cocoa\Transformer\Parsedown\Plugin\PluginInterface;
use SR\Exception\Logic\BadMethodCallException;
use SR\Exception\Runtime\RuntimeException;

class ParsedownRuntime extends \ParsedownExtra implements ParsedownRuntimeInterface
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
     * @param array $arguments
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
     * @param PluginInterface $plugin
     * @param bool            $before
     *
     * @return ParsedownRuntimeInterface
     */
    public function registerPlugin(PluginInterface $plugin, bool $before = false): ParsedownRuntimeInterface
    {
        if (!$plugin instanceof PluginBlockInterface && !$plugin instanceof PluginInlineInterface) {
            throw new RuntimeException('Plugin type "%s" is not supported.', $plugin->type());
        }

        $this->registerInst($plugin);
        $this->registerType($plugin, $before);

        return $this;
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
            return $this->pluginsI[$name]->invoke(...$arguments);
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
        if (isset($this->pluginsB[$name = substr($name, 6)])) {
            return $this->pluginsB[$name]->invoke(...$arguments);
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
     *
     * @param bool $before
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
            $this->inlineMarkerList .= $plugin->marker();
        }
    }
}
