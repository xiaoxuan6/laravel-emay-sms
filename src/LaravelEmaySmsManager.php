<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms;

use Illuminate\Support\Manager;

class LaravelEmaySmsManager extends Manager
{
    private $instance;

    /**
     * Get a driver instance.
     */
    public function driver($driver = null)
    {
        if (empty($this->instance)) {
            $this->instance = $this->createDriver($driver);
        }

        return $this->instance;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultDriver(): string
    {
        return '';
    }

    /**
     * @param $driver
     * @return Driver
     */
    protected function createDriver($driver = null): Driver
    {
        return new Driver($this->config->get('laravel-emay-sms', []));
    }
}
