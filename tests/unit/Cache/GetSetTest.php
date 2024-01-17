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

final class GetSetTest extends TestCase
{
    use CacheTrait;

    /**
     * Tests Phalcon\Cache :: get() - exception
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheGetSetException()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The key contains invalid characters');

        $value = $adapter->get('abc$^');

        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The key contains invalid characters');

        $value = $adapter->set('abc$^', 'test');
    }

    /**
     * Tests Phalcon\Cache :: get()/set()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheSetGet()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $key1 = uniqid();
        $key2 = uniqid();
        $key3 = 'key.' . uniqid();


        $adapter->set($key1, 'test');
        $this->assertTrue($adapter->has($key1));

        $adapter->set($key2, 'test');
        $this->assertTrue($adapter->has($key2));

        $adapter->set($key3, 'test');
        $this->assertTrue($adapter->has($key3));
        $this->assertEquals('test', $adapter->get($key1));
        $this->assertEquals('test', $adapter->get($key2));
        $this->assertEquals('test', $adapter->get($key3));
    }
}
