<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms\Scenes;

use Illuminate\Support\Arr;
use Vinhson\LaravelEmaySms\Result\{GetBalanceResult, GetMoResult, GetReportResult, SendPersonalitySMSResult, SendSimpleinterSMSResult};

class NoteSMSHandler extends Handler
{
    private const SAFE_URI = [
        'inter_single' => '/inter/sendSingleSMS',
        'inter_batch' => '/inter/sendBatchSMS',
        'inter_batch_only' => '/inter/sendBatchOnlySMS',
        'inter_personality' => '/inter/sendPersonalitySMS',
        'inter_personality_all' => '/inter/sendPersonalityAllSMS',
        'inter_report' => '/inter/getReport',
        'inter_mo' => '/inter/getMo',
        'inter_balance' => '/inter/getBalance',
        'inter_create_template' => '/inter/createTemplateSMS',
        'inter_delete_template' => '/inter/deleteTemplateSMS',
        'inter_query_template' => '/inter/queryTemplateSMS',
        'inter_send_template_normal' => '/inter/sendTemplateNormalSMS',
        'inter_send_template_variable' => '/inter/sendTemplateVariableSMS',
    ];

    private const GENERAL_URI = [
        'simpleinter_send' => '/simpleinter/sendSMS',
        'simpleinter_send_personality' => '/simpleinter/sendPersonalitySMS',
        'simpleinter_report' => '/simpleinter/getReport',
        'simpleinter_mo' => '/simpleinter/getMo',
        'simpleinter_balance' => '/simpleinter/getBalance',
        'inter_send_short_link_sms' => '/inter/sendShortLinkSMS',
        'inter_short_link' => '/inter/getShortLink',
    ];

    /**
     * 发送短信接口
     *
     * @param $mobiles
     * @param $content
     * @param string $customSmsId
     * @param string $extendedCode
     * @return SendSimpleinterSMSResult
     */
    public function sendSimpleinterSMS($mobiles, $content, string $customSmsId = '', string $extendedCode = ''): SendSimpleinterSMSResult
    {
        $params = [
            'mobiles' => implode(',', Arr::wrap($mobiles)),
            'content' => $content,
            'customSmsId' => $customSmsId,
            'extendedCode' => $extendedCode,
        ];

        return new SendSimpleinterSMSResult($this->request(self::GENERAL_URI['simpleinter_send'], $params));
    }

    /**
     * 个性短信接口
     *
     * @param array $mobileContent
     * @param string $customSmsId
     * @param string $extendedCode
     * @return SendPersonalitySMSResult
     */
    public function sendPersonalitySMS(array $mobileContent = [], string $customSmsId = '', string $extendedCode = ''): SendPersonalitySMSResult
    {
        $params = $mobileContent + [
                'customSmsId' => $customSmsId,
                'extendedCode' => $extendedCode,
            ];

        return new SendPersonalitySMSResult($this->request(self::GENERAL_URI['simpleinter_send_personality'], $params));
    }

    /**
     * 获取状态报告接口
     *
     * @param int $number
     * @return GetReportResult
     */
    public function getReport(int $number = 500): GetReportResult
    {
        return new GetReportResult($this->request(self::GENERAL_URI['simpleinter_report'], ['number' => $number]));
    }

    /**
     * 获取上行接口
     *
     * @param int $number
     * @return GetMoResult
     */
    public function getMo(int $number = 500): GetMoResult
    {
        return new GetMoResult($this->request(self::GENERAL_URI['simpleinter_mo'], ['number' => $number]));
    }

    /**
     * 获取余额接口
     *
     * @return GetBalanceResult
     */
    public function getBalance(): GetBalanceResult
    {
        return new GetBalanceResult($this->request(self::GENERAL_URI['simpleinter_balance']));
    }
}
