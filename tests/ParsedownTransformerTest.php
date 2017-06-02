<?php

/*
 * This file is part of the `src-run/cocoa-markdown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Markdown\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use SR\Cocoa\Transformer\CacheableTransformerInterface;
use SR\Cocoa\Transformer\Markdown\MarkdownCacheableTransformer;
use SR\Cocoa\Transformer\Markdown\MarkdownTransformer;
use SR\Cocoa\Transformer\Markdown\Runtime\RuntimeNormal;
use SR\Cocoa\Transformer\TransformerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Class ExceptionTest.
 */
class ParsedownTransformerTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(TransformerInterface::class, $this->getTransformerInstance());
    }

    /**
     * @return array
     */
    public static function dataTransformerProvider(): array
    {
        return array_map(null,
            glob(__DIR__.'/Fixtures/markdown/*/provided.md'),
            glob(__DIR__.'/Fixtures/markdown/*/expected.html'));
    }

    /**
     * @param string $providedFile
     * @param string $expectedFile
     *
     * @dataProvider dataTransformerProvider
     */
    public function testTransformer(string $providedFile, string $expectedFile)
    {
        $provided = file_get_contents($providedFile);
        $expected = file_get_contents($expectedFile);

        $transformer = $this->getTransformerInstance();

        if (false !== strpos($providedFile, 'custom-runtime')) {
            $transformer->setRuntime(new RuntimeNormal());
        }

        if (false !== strpos($providedFile, 'inline')) {
            $transformer->setBlock(false);
        }

        $this->assertSame($expected, $transformer->transform($provided),
            sprintf('Input markdown "%s" should compile into output html "%s"', $providedFile, $expectedFile));
    }

    public function testSupports()
    {
        $this->assertTrue($this->getTransformerInstance()->supports('markdown'));
        $this->assertTrue($this->getCacheableTransformerInstance()->supports('markdown'));
    }

    private function getTransformerInstance(): MarkdownTransformer
    {
        return new MarkdownTransformer();
    }

    /**
     * @param CacheItemPoolInterface|null $cache
     * @param \DateInterval|null          $expiredAfter
     *
     * @return CacheableTransformerInterface
     */
    private function getCacheableTransformerInstance(CacheItemPoolInterface $cache = null, \DateInterval $expiredAfter = null): CacheableTransformerInterface
    {
        return new MarkdownCacheableTransformer($cache ?: $this->getArrayAdapterMock(), $expiredAfter);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ArrayAdapter
     */
    private function getArrayAdapterMock(): ArrayAdapter
    {
        return $this
            ->getMockBuilder(ArrayAdapter::class)
            ->getMockForAbstractClass();
    }
}
