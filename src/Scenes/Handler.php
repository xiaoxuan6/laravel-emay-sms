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

use Carbon\Carbon;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Exception\{GuzzleException, RequestException};

abstract class Handler
{
    private const BASE_URI = 'www.btom.cn:8080';

    private static $client;

    /**
     * @var string|mixed
     */
    private $appId;

    /**
     * @var string|mixed
     */
    private $secret;

    public function __construct($config)
    {
        $this->appId = $config['appId'] ?? '';
        $this->secret = $config['secret'] ?? '';
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        if (empty(self::$client)) {
            self::$client = new Client(['timeout' => 30, 'verify' => false]);
        }

        return self::$client;
    }

    /**
     * @param $uri
     * @param array $args
     * @return array
     */
    protected function request($uri, array $args = []): array
    {
        $timestamp = Carbon::now()->format('YmdHis');

        $params = [
            'appId' => $this->appId,
            'timestamp' => $timestamp,
        ];

        $params['sign'] = md5($this->appId . $this->secret . $timestamp);

        $url = sprintf('%s%s', self::BASE_URI, $uri) . '?' . http_build_query(array_merge($params, $args));

        return $this->call($url);
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $options
     * @return array
     */
    private function call($uri, string $method = Request::METHOD_GET, array $options = []): array
    {
        try {
            $result = $this->getClient()->request($method, $uri, $options);

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
