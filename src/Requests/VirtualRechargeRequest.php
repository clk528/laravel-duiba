<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/23
 * Time: 11:48
 */

namespace clk528\DuiBa\Requests;

use Exception;

class VirtualRechargeRequest extends Request
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
     * 虚拟商品充值的解析方法
     * 当用兑换虚拟商品时候，兑吧会发起虚拟商品请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
     * 返回格式为：
     * 成功：   {status:"success",credits:"10", supplierBizId:"no123456"}
     * 处理中： {status:"process ",credits:"10" , supplierBizId:"no123456"}
     * 失败：   {status:"fail ", errorMessage:"签名签证失败", supplierBizId:"no123456"}
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function handle(array $params)
    {
        if ($params["appKey"] != $this->appKey) {
            throw new Exception("appKey not match");
        }

        if ($params["timestamp"] == null) {
            throw new Exception("timestamp can't be null");
        }
        if (!$this->signVerify($params)) {
            throw new Exception("sign verify fail");
        }
        return $params;
    }
}