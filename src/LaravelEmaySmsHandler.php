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

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Exception\{GuzzleException, RequestException};
use Vinhson\LaravelEmaySms\Result\{GetBalanceResult, GetMoResult, GetReportResult, SendPersonalitySMSResult, SendSimpleinterSMSResult};

class LaravelEmaySmsHandler
{
    public const BASE_URI = 'www.btom.cn:8080';

    public static Client $client;

    public const SAFE_URI = [
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

    public const GENERAL_URI = [
        'simpleinter_send' => '/simpleinter/sendSMS',
        'simpleinter_send_personality' => '/simpleinter/sendPersonalitySMS',
        'simpleinter_report' => '/simpleinter/getReport',
        'simpleinter_mo' => '/simpleinter/getMo',
        'simpleinter_balance' => '/simpleinter/getBalance',
        'inter_send_short_link_sms' => '/inter/sendShortLinkSMS',
        'inter_short_link' => '/inter/getShortLink',
    ];

    /**
     * @var string|mixed
     */
    private string $appId;

    /**
     * @var string|mixed
     */
    private string $secret;

    public function __construct($config)
    {
        $this->appId = $config['appId'] ?? '';
        $this->secret = $config['secret'] ?? '';
    }

    /**
     * @return Client
     */
    public static function getClient(): Client
    {
        if (empty(self::$client)) {
            self::$client = new Client(['timeout' => 30, 'verify' => false]);
        }

        return self::$client;
    }

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

    /**
     * 发送短链短信接口
     *
     */
    public function sendShortLinkSMS()
    {
        $params = [
//            'gzip' => 'on'
//            'content' => '',
//            'url' => '',
//            'shortLinkRule' => '',
//            'timerTime' => '',
//            'extendedCode' => '',
//            'requestTime' => '',
//            'requestValidPeriod' => '',
        ];

//        return new GetMoResult($this->request(self::GENERAL_URI['inter_send_short_link_sms'], $params));
    }

    /**
     * 获取短链点击明细接口
     *
     * @return GetMoResult
     */
//    public function sendShortLinkSMS(): GetMoResult
//    {
//        return new GetMoResult($this->request(self::GENERAL_URI['inter_short_link'], ['number' => $number]));
//    }

    /**
     * @param $uri
     * @param array $args
     * @param string $method
     * @return array
     */
    public function request($uri, array $args = [], string $method = Request::METHOD_GET): array
    {
        $timestamp = Carbon::now()->format('YmdHis');

        $params = [
            'appId' => $this->appId,
            'timestamp' => $timestamp,
        ];

        $params['sign'] = md5($this->appId . $this->secret . $timestamp);

        $url = sprintf('%s%s', self::BASE_URI, $uri) . '?' . http_build_query(array_merge($params, $args));

        try {
            $result = $this->getClient()->request($method, $url);

            return [
                'status' => $result->getStatusCode(),
                'data' => json_decode($result->getBody()->getContents(), true),
                'msg' => 'ok'
            ];
        } catch (RequestException | GuzzleException $exception) {
            return [
                'status' => $exception->getCode(),
                'data' => '',
                'msg' => $exception->getMessage(),
            ];
        }
    }
}
