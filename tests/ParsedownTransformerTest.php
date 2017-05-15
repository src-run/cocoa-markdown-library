<?php

/*
 * This file is part of the `src-run/cocoa-parsedown-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Cocoa\Transformer\Parsedown\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use SR\Cocoa\Transformer\Parsedown\ParsedownTransformer;
use SR\Cocoa\Transformer\Parsedown\Runtime\ParsedownNormalRuntime;
use SR\Cocoa\Transformer\TransformerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Class ExceptionTest.
 */
class ParsedownTransformerTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(TransformerInterface::class, $this->getParsedownTransformerInstance());
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

        $transformer = $this->getParsedownTransformerInstance();

        if (false !== strpos($providedFile, 'extras-disabled')) {
            $transformer->setExtra(false);
        }

        if (false !== strpos($providedFile, 'custom-instance')) {
            $transformer->setExtra(false);
            $transformer->setRuntime(new ParsedownNormalRuntime());
        }

        $this->assertSame($expected, $transformer->transform($provided),
            sprintf('Input markdown "%s" should compile into output html "%s"', $providedFile, $expectedFile));
    }

    private function getParsedownTransformerInstance(CacheItemPoolInterface $cache = null, \DateInterval $expiredAfter = null): ParsedownTransformer
    {
        return new ParsedownTransformer($cache ?: $this->getArrayAdapterMock(), $expiredAfter);
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
