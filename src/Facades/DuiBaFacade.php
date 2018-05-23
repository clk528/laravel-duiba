<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/23
 * Time: 10:34
 */

namespace clk528\DuiBa\Facades;

use Illuminate\Support\Facades\Facade;

class DuiBaFacade extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'DuiBa';
    }
}