<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 16:52
 */

namespace clk528\DuiBa\Requests;

use clk528\DuiBa\Gateways\Contracts\GatewayInterface;
use Exception;

abstract class Request implements GatewayInterface
{
    protected $requestUrl = "http://www.duiba.com.cn/";

    protected $appKey;

    protected $appSecret;

    /**
     * md5签名，$array中务必包含 appSecret
     * @param array $array
     * @return string
     */
    public function sign(array $array)
    {
        ksort($array);
        $string = "";

        foreach ($array as $key => $value) {
            $string .= $value;
        }

        return md5($string);
    }

    /**
     * 构建参数请求的URL
     * @param $url
     * @param array $array
     * @return string
     */
    public function assembleUrl($url, array $array)
    {
        unset($array['appSecret']);
        return "{$this->requestUrl}{$url}?" . http_build_query($array);
    }

    /**
     * 签名验证,通过签名验证的才能认为是合法的请求
     * @param array $array
     * @return bool
     */
    public function signVerify(array $array): bool
    {
        $params = [
            'appSecret' => $this->appSecret
        ];

        foreach ($array as $key => $value) {
            if ($key != "sign") {
                $params[$key] = $value;
            }
        }
        if ($this->sign($params) == $array["sign"]) {
            return true;
        }
        return false;
    }

    abstract public function handle(array $params);
}