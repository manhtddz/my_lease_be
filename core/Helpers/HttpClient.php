<?php

namespace Core\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use function PHPUnit\Framework\isJson;

class HttpClient
{
    // method GET
    const METHOD_GET = 'GET';

    // method POST
    const METHOD_POST = 'POST';

    // default content type
    const CONTENT_TYPE = 'application/x-www-form-urlencoded;charset=UTF-8';

    /**
     * request API
     *
     * @param $url
     * @param array $params
     * @param string $method
     * @param array $headers
     * @return false|void
     * @throws GuzzleException
     */
    public static function request($url, array $params = [], string $method = self::METHOD_POST, array $headers = [])
    {
        $log = "URL: {$url}, Params: " . jsonEncode($params);

        if (empty($headers['Content-Type'])) {
            $headers['Content-Type'] = self::CONTENT_TYPE;
        }

        try {
            $config = [];

            if (!getConfig('http_client_verify')) $config['verify'] = false;

            if (!empty($headers)) $config['headers'] = $headers;

            $client = new Client($config);
            $request = $client->request($method, $url, ['form_params' => $params]);

            if ($request->getStatusCode() != 200) {
                logError(__('messages.api_not_connect') . '（' . __LINE__ . '行目）'
                    . PHP_EOL . '[Request] ' . $log);
                return false;
            }

            $content = $request->getBody()->getContents();
            return isJson($content) ? json_decode($content, true) : $content;
        } catch (\Exception $exception) {
            logError($exception->getMessage() . '（' . __LINE__ . '行目）'
                . PHP_EOL . '[Request] ' . $log
                . PHP_EOL . $exception->getTraceAsString());
            return false;
        }
    }
}
