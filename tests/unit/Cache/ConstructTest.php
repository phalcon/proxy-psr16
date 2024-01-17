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

use Phalcon\Cache\AdapterFactory;
use Phalcon\Proxy\Psr16\Cache;
use Phalcon\Storage\SerializerFactory;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

final class ConstructTest extends TestCase
{
    /**
     * Tests Phalcon\Cache :: __construct()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2024-01-17
     */
    public function testCacheCacheConstruct()
    {
        $serializer = new SerializerFactory();
        $factory    = new AdapterFactory($serializer);
        $options    = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200,
        ];

        $instance = $factory->newInstance('apcu', $options);

        $adapter = new Cache($instance);

        $this->assertInstanceOf(Cache::class, $adapter);
        $this->assertInstanceOf(CacheInterface::class, $adapter);
    }
}
