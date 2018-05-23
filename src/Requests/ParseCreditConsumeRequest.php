<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/23
 * Time: 11:31
 */

namespace clk528\DuiBa\Requests;

use Exception;

class ParseCreditConsumeRequest extends Request
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
     * 积分消耗请求的解析方法
     * 当用户进行兑换时，兑吧会发起积分扣除请求，开发者收到请求后，可以通过此方法进行签名验证与解析，然后返回相应的格式
     * 返回格式为：
     * 成功：{"status":"ok", 'errorMessage':'', 'bizId': '20140730192133033', 'credits': '100'}
     * 失败：{'status': 'fail','errorMessage': '失败原因（显示给用户）','credits': '100'}
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
        $verify = $this->signVerify($params);
        if (!$verify) {
            throw new Exception("sign verify fail");
        }
        return $params;
    }
}