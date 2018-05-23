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
            $string = $string . $value;
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
        $url .= "{$this->requestUrl}{$url}?" . http_build_query($array);
        return $url;
    }

    /**
     * 签名验证,通过签名验证的才能认为是合法的请求
     * @param array $array
     * @return bool
     */
    public function signVerify(array $array): bool
    {
        foreach ($array as $key => $value) {
            if ($key != "sign") {
                $array[$key] = $value;
            }
        }
        $sign = $this->sign($array);
        if ($sign == $array["sign"]) {
            return true;
        }
        return false;
    }

    /**
     * 积分消耗请求的解析方法
     * 当用户进行兑换时，兑吧会发起积分扣除请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
     * 返回格式为：
     * 成功：{"status":"ok", 'errorMessage':'', 'bizId': '20140730192133033', 'credits': '100'}
     * 失败：{'status': 'fail','errorMessage': '失败原因（显示给用户）','credits': '100'}
     * @param $request_array
     * @return mixed
     * @throws Exception
     */
    public function parseCreditConsume($request_array)
    {
        if ($request_array["appKey"] != $this->appKey) {
            throw new Exception("appKey not match");
        }
        if ($request_array["timestamp"] == null) {
            throw new Exception("timestamp can't be null");
        }
        $verify = $this->signVerify($request_array);
        if (!$verify) {
            throw new Exception("sign verify fail");
        }

        $ret = $request_array;
        return $ret;
    }

    /**
     * 加积分请求的解析方法
     *  当用点击签到，或者有签到弹层时候，兑吧会发起加积分请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
     *  返回格式为：
     *  成功：{"status":"ok", 'errorMessage':'', 'bizId': '20140730192133033', 'credits': '100'}
     *  失败：{'status': 'fail','errorMessage': '失败原因（显示给用户）','credits': '100'}
     * @param $request_array
     * @return mixed
     * @throws Exception
     */
    public function addCreditsConsume($request_array)
    {
        if ($request_array["appKey"] != $this->appKey) {
            throw new Exception("appKey not match");
        }
        if ($request_array["timestamp"] == null) {
            throw new Exception("timestamp can't be null");
        }
        if (!$this->signVerify($request_array)) {
            throw new Exception("sign verify fail");
        }
        return $request_array;
    }


    /**
     * 虚拟商品充值的解析方法
     *  当用兑换虚拟商品时候，兑吧会发起虚拟商品请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
     *  返回格式为：
     *   成功：   {status:"success",credits:"10", supplierBizId:"no123456"}
     *    处理中： {status:"process ",credits:"10" , supplierBizId:"no123456"}
     *    失败：   {status:"fail ", errorMessage:"签名签证失败", supplierBizId:"no123456"}
     * @param $request_array
     * @return mixed
     * @throws Exception
     */
    public function virtualRecharge($request_array)
    {
        if ($request_array["appKey"] != $this->appKey) {
            throw new Exception("appKey not match");
        }

        if ($request_array["timestamp"] == null) {
            throw new Exception("timestamp can't be null");
        }
        if (!$this->signVerify($request_array)) {
            throw new Exception("sign verify fail");
        }
        return $request_array;
    }


    /**
     * 兑换订单的结果通知请求的解析方法
     * 当兑换订单成功时，兑吧会发送请求通知开发者，兑换订单的结果为成功或者失败，如果为失败，开发者需要将积分返还给用户
     * @param $request_array
     * @return array
     * @throws Exception
     */
    public function parseCreditNotify($request_array)
    {
        if ($request_array["appKey"] != $this->appKey) {
            throw new Exception("appKey not match");
        }
        if ($request_array["timestamp"] == null) {
            throw new Exception("timestamp can't be null");
        }
        if (!$this->signVerify($request_array)) {
            throw new Exception("sign verify fail");
        }
        return [
            "success" => $request_array["success"],
            "errorMessage" => $request_array["errorMessage"],
            "bizId" => $request_array["bizId"]
        ];
    }

    abstract public function handle(array $params);
}