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
use Phalcon\Proxy\Psr16\Tests\Support\Traits\CacheTrait;
use PHPUnit\Framework\TestCase;

use function uniqid;

final class ClearTest extends TestCase
{
    use CacheTrait;

    /**
     * Tests Phalcon\Cache :: clear()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheClear()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $key1 = uniqid();
        $key2 = uniqid();

        $adapter->set($key1, 'test');
        $this->assertTrue($adapter->has($key1));

        $adapter->set($key2, 'test');
        $this->assertTrue($adapter->has($key2));
        $this->assertTrue($adapter->clear());
        $this->assertFalse($adapter->has($key1));
        $this->assertFalse($adapter->has($key2));
    }
}
