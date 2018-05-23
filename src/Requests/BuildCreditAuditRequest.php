<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 18:14
 */

namespace clk528\DuiBa\Requests;

/**
 * 兑换订单审核请求
 * 有些兑换请求可能需要进行审核，开发者可以通过此API接口来进行批量审核，也可以通过兑吧后台界面来进行审核处理
 * Class BuildCreditAuditRequest
 * @package clk528\DuiBa\Requests
 */

class BuildCreditAuditRequest extends Request
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
        if (isset($params['passOrderNums']) && !empty($params['passOrderNums'])) {
            $string = null;
            foreach ($params['passOrderNums'] as $key => $value) {
                if ($string == null) {
                    $string = $value;
                } else {
                    $string .= "," . $value;
                }
            }
            $params["passOrderNums"] = $string;
        }

        if (isset($params['rejectOrderNums']) && !empty($params['rejectOrderNums'])) {
            $string = null;
            foreach ($params['rejectOrderNums'] as $key => $value) {
                if ($string == null) {
                    $string = $value;
                } else {
                    $string .= "," . $value;
                }
            }
            $params["rejectOrderNums"] = $string;
        }
        $array['timestamp'] = time() * 1000;
        $params['sign'] = $this->sign(array_merge($this->config, $params));
        return $this->assembleUrl("audit/apiAudit", $params);
    }
}