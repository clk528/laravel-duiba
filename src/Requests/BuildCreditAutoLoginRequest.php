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

    public function __construct()
    {
        parent::__construct();
        $config = config('duiba');
        $this->config = $config;
    }

    public function handle(array $params)
    {
        $config = config('duiba', []);

        $params['timestamp'] = time() * 1000;
        $params = array_merge($config, $params);
        $params['sign'] = $this->sign($params);
        return $this->assembleUrl("autoLogin/autologin", $array);
    }
}