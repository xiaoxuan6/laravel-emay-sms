<?php
/**
 * This file is part of PHP CS Fixer.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\LaravelEmaySms\Tests;

use Vinhson\LaravelEmaySms\LaravelEmaySmsHandler;
use Vinhson\LaravelEmaySms\Result\{GetBalanceResult, GetMoResult, GetReportResult, SendPersonalitySMSResult, SendSimpleinterSMSResult};

class FeaturesTest extends TestCase
{
    public function testSendSimpleinterSms()
    {
        /**
         * @var $result SendSimpleinterSMSResult
         * @var $class LaravelEmaySmsHandler
         */
        $class = $this->mockery(
            LaravelEmaySmsHandler::class,
            'sendSimpleinterSMS',
            ['17621838830', 'test'],
            new SendSimpleinterSMSResult($this->getResponse(json_decode(file_get_contents(__DIR__ . '/Result/sendSimpleinterSMSResult.json'), true)))
        );

        $result = $class->sendSimpleinterSMS('17621838830', 'test');

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testSendPersonalitySMS()
    {
        /**
         * @var $result SendPersonalitySMSResult
         * @var $class LaravelEmaySmsHandler
         */
        $class = $this->mockery(
            LaravelEmaySmsHandler::class,
            'sendPersonalitySMS',
            [['17621838830' => 'test']],
            new SendPersonalitySMSResult($this->getResponse(json_decode(file_get_contents(__DIR__ . '/Result/sendPersonalitySMSResult.json'), true)))
        );

        $result = $class->sendPersonalitySMS(['17621838830' => 'test']);

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testGetReport()
    {
        /**
         * @var $result GetReportResult
         * @var $class LaravelEmaySmsHandler
         */
        $class = $this->mockery(
            LaravelEmaySmsHandler::class,
            'getReport',
            '10',
            new GetReportResult($this->getResponse(json_decode(file_get_contents(__DIR__ . '/Result/getReportResult.json'), true)))
        );

        $result = $class->getReport(10);

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testGetMo()
    {
        /**
         * @var $result GetMoResult
         * @var $class LaravelEmaySmsHandler
         */
        $class = $this->mockery(
            LaravelEmaySmsHandler::class,
            'getMo',
            '10',
            new GetMoResult($this->getResponse(json_decode(file_get_contents(__DIR__ . '/Result/getMoResult.json'), true)))
        );

        $result = $class->getMo(10);

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testGetBalance()
    {
        /**
         * @var $result GetBalanceResult
         * @var $class LaravelEmaySmsHandler
         */
        $class = $this->mockery(
            LaravelEmaySmsHandler::class,
            'getBalance',
            null,
            new GetBalanceResult($this->getResponse(json_decode(file_get_contents(__DIR__ . '/Result/getBalanceResult.json'), true)))
        );

        $result = $class->getBalance();

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    /**
     * @param $data
     * @return array
     */
    private function getResponse($data): array
    {
        return [
            'status' => 200,
            'data' => $data,
            'msg' => 'ok'
        ];
    }
}
