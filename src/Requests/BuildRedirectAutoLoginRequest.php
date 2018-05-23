<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 18:05
 */

namespace clk528\DuiBa\Requests;

/**
 * 生成直达商城内部页面的免登录地址
 * 通过此方法生成的免登陆地址，可以通过redirect参数，跳转到积分商城任意页面
 * Class BuildRedirectAutoLoginRequest
 * @package clk528\DuiBa\Requests
 */
class BuildRedirectAutoLoginRequest extends Request
{
    protected $config;

    protected $appKey;

    protected $appSecret;

    public function __construct(array $config = [])
    {
        $this->appSecret = $config['appSecret'];
        $this->appKey = $config['appKey'];
        $this->config = $config;
    }

    public function handle(array $params)
    {
        unset($this->config['redirect']);
        $array['timestamp'] = time() * 1000;
        $array['sign'] = $this->sign(array_merge($this->config, $params));
        return $this->assembleUrl("autoLogin/autologin", $array);
    }
}