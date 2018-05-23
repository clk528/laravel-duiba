<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/23
 * Time: 11:50
 */

namespace clk528\DuiBa\Requests;

use Exception;

class ParseCreditNotifyRequest extends Request
{
    protected $config;

    protected $appKey;

    protected $appSecret;

    public function __construct(array $config = [])
    {
        $config = config('duiba');
        $this->appSecret = $config['appSecret'];
        $this->appKey = $config['appKey'];
        $this->config = $config;
    }

    /**
     * 兑换订单的结果通知请求的解析方法
     * 当兑换订单成功时，兑吧会发送请求通知开发者，兑换订单的结果为成功或者失败，如果为失败，开发者需要将积分返还给用户
     * @param $params
     * @return array
     * @throws Exception
     */
    public function handle(array $params)
    {
        if (!isset($params["appKey"]) || $params["appKey"] != $this->appKey) {
            throw new Exception("appKey not match");
        }

        if (!isset($params["timestamp"]) || empty($params["timestamp"])) {
            throw new Exception("timestamp can't be null");
        }

        if (!$this->signVerify($params)) {
            throw new Exception("sign verify fail");
        }
        return [
            "success" => $params["success"],
            "errorMessage" => $params["errorMessage"],
            "bizId" => $params["bizId"]
        ];
    }
}