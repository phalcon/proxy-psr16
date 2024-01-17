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

namespace Phalcon\Proxy\Psr16\Tests\Unit\Cache;

use Phalcon\Proxy\Psr16\Cache;
use Phalcon\Proxy\Psr16\InvalidArgumentException;
use Phalcon\Proxy\Psr16\Tests\Support\Traits\CacheTrait;
use PHPUnit\Framework\TestCase;

use function uniqid;

final class DeleteMultipleTest extends TestCase
{
    use CacheTrait;

    /**
     * Tests Phalcon\Cache :: deleteMultiple()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheDeleteMultiple()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $key1 = uniqid();
        $key2 = uniqid();
        $key3 = uniqid();
        $key4 = uniqid();

        $adapter->setMultiple(
            [
                $key1 => 'test1',
                $key2 => 'test2',
                $key3 => 'test3',
                $key4 => 'test4',
            ]
        );

        $this->assertTrue($adapter->has($key1));
        $this->assertTrue($adapter->has($key2));
        $this->assertTrue($adapter->has($key3));
        $this->assertTrue($adapter->has($key4));

        $this->assertTrue(
            $adapter->deleteMultiple(
                [
                    $key1,
                    $key2,
                ]
            )
        );

        $this->assertFalse($adapter->has($key1));
        $this->assertFalse($adapter->has($key2));
        $this->assertTrue($adapter->has($key3));
        $this->assertTrue($adapter->has($key4));

        $this->assertTrue($adapter->delete($key3));
        $this->assertTrue($adapter->delete($key4));

        $this->assertFalse(
            $adapter->deleteMultiple(
                [
                    $key3,
                    $key4,
                ]
            )
        );

        $this->assertFalse($adapter->has($key1));
        $this->assertFalse($adapter->has($key2));
        $this->assertFalse($adapter->has($key3));
        $this->assertFalse($adapter->has($key4));
    }

    /**
     * Tests Phalcon\Cache :: deleteMultiple() - exception
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheDeleteMultipleException()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The keys need to be an array or instance of Traversable');

        $actual = $adapter->deleteMultiple(1234);
    }
}
