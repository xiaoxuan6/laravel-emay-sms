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

use Vinhson\LaravelEmaySms\Driver;
use Vinhson\LaravelEmaySms\Result\{SendSingleIMSResult};
use Vinhson\LaravelEmaySms\Handler\InternationalSMSHandler;

class InternationalSMSTest extends TestCase
{
    public function testSendSingleIMS()
    {
        /**
         * @var $result SendSingleIMSResult
         * @var $class Driver
         */
        $class = $this->createDriver(
            $this->mockery(
                InternationalSMSHandler::class,
                'sendSingleIMS',
                ['123', '123'],
                new SendSingleIMSResult($this->getResponse(json_decode(file_get_contents(__DIR__ . '/Result/sendSingleIMSResult.json'), true)))
            ),
            'internationalSMS'
        );

        $result = $class->internationalSMS()->sendSingleIMS('123', '123');

        $this->assertTrue($result->isSuccess(), $result->getReason());
        $this->assertFalse($result->isFail(), $result->getReason());
        $this->assertNotEmpty($result->getData(), $result->getReason());
    }
}
