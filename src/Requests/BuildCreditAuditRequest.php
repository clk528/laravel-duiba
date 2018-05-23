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

        $config = config('duiba', []);

        $params['timestamp'] = time() * 1000;
        $params = array_merge($config, $params);
        $params['sign'] = $this->sign($params);
        return $this->assembleUrl("audit/apiAudit", $params);
    }
}