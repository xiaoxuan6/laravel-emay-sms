<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms\Facades;

use Illuminate\Support\Facades\Facade;
use Vinhson\LaravelEmaySms\Handler\{InternationalSMSHandler, NoteSMSHandler};

/**
 * @method static NoteSMSHandler noteSms()
 * @method static InternationalSMSHandler internationalSMS()
 *
 * @see \Vinhson\LaravelEmaySms\Driver::class
 */
class LaravelEmaySms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-emay-sms';
    }
}
