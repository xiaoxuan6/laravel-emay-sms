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
 * @method static sendSimpleinterSMS($mobiles, $content, string $customSmsId = '', string $extendedCode = '')
 * @method static sendPersonalitySMS(array $mobileContent = [], string $customSmsId = '', string $extendedCode = '')
 * @method static getReport(int $number = 500)
 * @method static getMo(int $number = 500)
 * @method static getBalance()
 *
 * @see \Vinhson\LaravelEmaySms\LaravelEmaySmsHandler::class
 */
class LaravelEmaySms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-emay-sms';
    }
}
