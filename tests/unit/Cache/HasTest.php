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

final class HasTest extends TestCase
{
    use CacheTrait;

    /**
     * Tests Phalcon\Cache :: has()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheHas()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);
        $key      = uniqid();

        $this->assertFalse($adapter->has($key));

        $adapter->set($key, 'test');
        $this->assertTrue($adapter->has($key));
    }

    /**
     * Tests Phalcon\Cache :: has() - exception
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheHasException()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The key contains invalid characters');

        $value = $adapter->has('abc$^');
    }
}
