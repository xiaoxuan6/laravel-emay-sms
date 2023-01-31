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

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Request;

abstract class Handler
{
    private const BASE_URI = 'www.btom.cn:8080';

    /**
     * @var array|mixed
     */
    private mixed $secret;
    /**
     * @var array|mixed
     */
    private mixed $appId;

    public function __construct(
        protected Repository $config
    )
    {
        $this->appId = $this->config->get('laravel-emay-sms.app_id', '');
        $this->secret = $this->config->get('laravel-emay-sms.secret', '');
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
     * @param array $args
     * @return array
     */
    protected function postRequest($uri, array $args = []): array
    {
        $timestamp = Carbon::now()->format('YmdHis');

        $params = [
            'appId' => $this->appId,
            'timestamp' => $timestamp,
        ];

        $params['sign'] = md5($this->appId . $this->secret . $timestamp);

        $params = array_merge($params, $args);

        $url = sprintf('%s%s', self::BASE_URI, $uri);

        return $this->call($url, Request::METHOD_POST, ['body' => json_encode($params, JSON_UNESCAPED_UNICODE)]);
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
            $result = Http::send($method, $uri, $options);

            return [
                'status' => $result->status(),
                'data' => $result->json(),
                'msg' => 'ok',
            ];
        } catch (\Error $exception) {
            return [
                'status' => $exception->getCode(),
                'data' => '',
                'msg' => $exception->getMessage(),
            ];
        }
    }
}
