<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms\Result;

use Illuminate\Support\Arr;

abstract class Result
{
    public $response;

    public const SUCCESS_CODE = 'SUCCESS';

    public function __construct($reponse)
    {
        $this->response = $reponse;
    }

    public function isSuccess(): bool
    {
        return $this->response['status'] == 200 && $this->get('code') == self::SUCCESS_CODE;
    }

    public function isFail(): bool
    {
        return ! $this->isSuccess();
    }

    public function getData(): array
    {
        return $this->response['data'];
    }

    public function getReason(): string
    {
        return $this->response['msg'];
    }

    public function get($key)
    {
        return Arr::get($this->getData(), $key, '');
    }
}
