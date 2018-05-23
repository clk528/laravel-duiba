<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/23
 * Time: 16:50
 */

namespace clk528\DuiBa\Requests;

use Exception;

class VerfifySignRequest  extends Request
{
    /**
     * 数据验签
     * @param array $params
     * @return array
     */
    public function handle(array $params)
    {
        if (!$this->signVerify($params)) {
            throw new Exception("sign verify fail");
        }
        return $params;
    }
}