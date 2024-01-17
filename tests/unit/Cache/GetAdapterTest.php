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

use Phalcon\Cache\Adapter\AdapterInterface;
use Phalcon\Proxy\Psr16\Cache;
use Phalcon\Proxy\Psr16\Tests\Support\Traits\CacheTrait;
use PHPUnit\Framework\TestCase;

final class GetAdapterTest extends TestCase
{
    use CacheTrait;

    /**
     * Tests Phalcon\Cache :: getAdapter()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheGetAdapter()
    {
        $instance = $this->getNewInstance();
        $adapter  = new Cache($instance);

        $class  = AdapterInterface::class;
        $actual = $adapter->getAdapter();
        $this->assertInstanceOf($class, $actual);
    }
}
