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

use Vinhson\LaravelEmaySms\Handler\NoteSMSHandler;
use Vinhson\LaravelEmaySms\Result\GetBalanceResult;
use Vinhson\LaravelEmaySms\Result\GetMoResult;
use Vinhson\LaravelEmaySms\Result\GetReportResult;
use Vinhson\LaravelEmaySms\Result\SendPersonalitySMSResult;
use Vinhson\LaravelEmaySms\Result\SendSimpleinterSMSResult;
use Vinhson\LaravelEmaySms\{Driver};

class NoteSMSTest extends TestCase
{
    public function testSendSimpleinterSms()
    {
        /**
         * @var $result SendSimpleinterSMSResult
         * @var $class Driver
         */
        $class = $this->createDriver(
            $this->mockery(
                NoteSMSHandler::class,
                'sendSimpleinterSMS',
                ['17621838830', 'test'],
                new SendSimpleinterSMSResult($this->getResponse(json_decode(file_get_contents(__DIR__.'/Result/sendSimpleinterSMSResult.json'), true)))
            ),
            'noteSms'
        );

        $result = $class->noteSMS()->sendSimpleinterSMS('17621838830', 'test');

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testSendPersonalitySMS()
    {
        /**
         * @var $result SendPersonalitySMSResult
         * @var $class Driver
         */
        $class = $this->createDriver(
            $this->mockery(
                NoteSMSHandler::class,
                'sendPersonalitySMS',
                [['17621838830' => 'test']],
                new SendPersonalitySMSResult($this->getResponse(json_decode(file_get_contents(__DIR__.'/Result/sendPersonalitySMSResult.json'), true)))
            ),
            'noteSms'
        );

        $result = $class->noteSMS()->sendPersonalitySMS(['17621838830' => 'test']);

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testGetReport()
    {
        /**
         * @var $result SendPersonalitySMSResult
         * @var $class Driver
         */
        $class = $this->createDriver(
            $this->mockery(
                NoteSMSHandler::class,
                'getReport',
                '10',
                new GetReportResult($this->getResponse(json_decode(file_get_contents(__DIR__.'/Result/getReportResult.json'), true)))
            ),
            'noteSms'
        );

        $result = $class->noteSMS()->getReport(10);

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testGetMo()
    {
        /**
         * @var $result SendPersonalitySMSResult
         * @var $class Driver
         */
        $class = $this->createDriver(
            $this->mockery(
                NoteSMSHandler::class,
                'getMo',
                '10',
                new GetMoResult($this->getResponse(json_decode(file_get_contents(__DIR__.'/Result/getMoResult.json'), true)))
            ),
            'noteSms'
        );

        $result = $class->noteSMS()->getMo(10);

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }

    public function testGetBalance()
    {
        /**
         * @var $result SendPersonalitySMSResult
         * @var $class Driver
         */
        $class = $this->createDriver(
            $this->mockery(
                NoteSMSHandler::class,
                'getBalance',
                null,
                new GetBalanceResult($this->getResponse(json_decode(file_get_contents(__DIR__.'/Result/getBalanceResult.json'), true)))
            ),
            'noteSms'
        );

        $result = $class->noteSMS()->getBalance();

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }
}
