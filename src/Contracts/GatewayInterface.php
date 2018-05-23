<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 16:16
 */

namespace clk528\DuiBa\Gateways\Contracts;


interface GatewayInterface
{
    /**md5签名，$array中务必包含 appSecret
     * @param array $array
     * @return string
     */
    public function sign(array $array);

    /**
     * 签名验证,通过签名验证的才能认为是合法的请求
     * @param array $array
     * @return bool
     */
    function signVerify(array $array):bool ;

    /**
     * 构建参数请求的URL
     * @param $url
     * @param array $array
     * @return string
     */
    function assembleUrl($url, array $array);
}