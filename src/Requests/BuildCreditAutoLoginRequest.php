<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 17:45
 */

namespace clk528\DuiBa\Requests;

/**
 * 生成自动登录地址
 * 通过此方法生成的地址，可以让用户免登录，进入积分兑换商城
 * Class BuildCreditAutoLoginRequest
 * @package clk528\DuiBa\Requests
 */
class BuildCreditAutoLoginRequest extends Request
{
    protected $config;

    protected $appKey;

    protected $appSecret;

    public function __construct(array $config)
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
        return $this->assembleUrl("autoLogin/autologin", $array);
    }
}