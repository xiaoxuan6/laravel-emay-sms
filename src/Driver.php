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

use Illuminate\Config\Repository;
use Vinhson\LaravelEmaySms\Handler\InternationalSMSHandler;
use Vinhson\LaravelEmaySms\Handler\NoteSMSHandler;

class Driver
{
    public function __construct(
        protected Repository $config
    ) {
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
