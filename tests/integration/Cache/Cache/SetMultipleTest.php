<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Proxy\Psr16\Tests\Integration\Cache\Cache;

use Codeception\Stub;
use IntegrationTester;
use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Cache\Exception\Exception;
use Phalcon\Proxy\Psr16\Cache;
use Phalcon\Proxy\Psr16\InvalidArgumentException;
use Phalcon\Storage\SerializerFactory;
use PHPUnit\Framework\TestCase;

use function uniqid;

class SetMultipleTest extends TestCase
{
    /**
     * Tests Phalcon\Cache :: setMultiple()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheSetMultiple()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $key1 = uniqid();
        $key2 = uniqid();
        $adapter->setMultiple(
            [
                $key1 => 'test1',
                $key2 => 'test2',
            ]
        );

        $this->assertTrue($adapter->has($key1));
        $this->assertTrue($adapter->has($key2));

        $expected = [
            $key1     => 'test1',
            $key2     => 'test2',
            'unknown' => 'default-unknown',
        ];
        $actual   = $adapter->getMultiple([$key1, $key2, 'unknown'], 'default-unknown');
        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Cache :: setMultiple() - false
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheSetMultipleFalse()
    {
        $instance = $this->getNewInstance();
        $mock     = $this
            ->getMockBuilder(Cache::class)
            ->setConstructorArgs([$instance])
            ->getMock()
        ;

        $mock->method('set')->willReturn(false);

        $key1   = uniqid();
        $key2   = uniqid();
        $actual = $mock->setMultiple(
            [
                $key1 => 'test1',
                $key2 => 'test2',
            ]
        );

        $this->assertFalse($actual);
    }

    /**
     * Tests Phalcon\Cache :: setMultiple() - exception
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheSetMultipleException()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The key contains invalid characters');

        $adapter->setMultiple(
            [
                'abc$^' => 'test1',
                'abd$^' => 'test2',
            ]
        );

        $adapter  = new Cache($instance);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The keys need to be an array or instance of Traversable'
        );

        $adapter->setMultiple(1234);
    }

    /**
     * @return AdapterInterface
     * @throws Exception
     */
    private function getNewInstance(): AdapterInterface
    {
        $serializer = new SerializerFactory();
        $factory    = new AdapterFactory($serializer);
        $instance   = $factory->newInstance('apcu');

        return $instance;
    }
}
