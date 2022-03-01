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

use Vinhson\LaravelEmaySms\Handler\{InternationalSMSHandler, NoteSMSHandler};

class Driver
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return NoteSMSHandler
     */
    public function noteSMS(): NoteSMSHandler
    {
        return new NoteSMSHandler($this->config);
    }

    /**
     * @return InternationalSMSHandler
     */
    public function internationalSMS(): InternationalSMSHandler
    {
        return new InternationalSMSHandler($this->config);
    }
}
