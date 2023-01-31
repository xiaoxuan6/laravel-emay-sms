<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vinhson\LaravelEmaySms\Handler;

use Vinhson\LaravelEmaySms\Result\SendSingleIMSResult;

class InternationalSMSHandler extends Handler
{
    public const GENERAL_URI = [
        'send_single_ims' => '/inter/sendSingleIMS',
    ];

    /**
     * @param $mobile
     * @param $content
     * @param  string  $customImsId
     * @return SendSingleIMSResult
     */
    public function sendSingleIMS($mobile, $content, string $customImsId = ''): SendSingleIMSResult
    {
        $params = [
            'mobile' => $mobile,
            'content' => $content,
            'customImsId' => $customImsId,
        ];

        return new SendSingleIMSResult($this->postRequest(self::GENERAL_URI['send_single_ims'], $params));
    }
}
