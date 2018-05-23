<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 18:08
 */

namespace clk528\DuiBa\Requests;

/**
 * 生成订单查询请求地址
 * orderNum 和 bizId 二选一，不填的项目请使用空字符串
 * Class BuildCreditOrderStatusRequest
 * @package clk528\DuiBa\Requests
 */
class BuildCreditOrderStatusRequest extends Request
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

    public function handle(array $params)
    {
        $params['timestamp'] = time() * 1000;
        $params = array_merge($this->config, $params);
        $params['sign'] = $this->sign($params);
        return $this->assembleUrl("status/orderStatus", $params);
    }
}