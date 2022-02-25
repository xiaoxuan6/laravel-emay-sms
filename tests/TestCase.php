<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms\Tests;

use Mockery;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Application;
use Mockery\{LegacyMockInterface, MockInterface};
use Vinhson\LaravelEmaySms\Facades\LaravelEmaySms;
use Vinhson\LaravelEmaySms\LaravelEmaySmsServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-emay-sms', [
            'appId' => '******',
            'secret' => '******',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelEmaySmsServiceProvider::class
        ];
    }

    /**
     * Get package aliases.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'laravel-emay-sms' => LaravelEmaySms::class,
        ];
    }

    /**
     * @param $class
     * @param $method
     * @param $params
     * @param $response
     * @return LegacyMockInterface|MockInterface|null
     */
    protected function mockery($class, $method, $params, $response): MockInterface|LegacyMockInterface|null
    {
        return Mockery::mock($class)
            ->shouldReceive($method)
            ->once()
            ->withArgs(Arr::wrap($params))
            ->andReturn($response)
            ->getMock();
    }
}
