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

/**
 * @method static sendSimpleinterSms($mobiles, $content)
 */
class LaravelEmaySms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-emay-sms';
    }
}
