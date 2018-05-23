<?php
/**
 * Created by PhpStorm.
 * User: clk
 * Date: 2018/5/22
 * Time: 16:04
 */

namespace clk528\DuiBa;

class DuiBa
{
    public static function __callStatic($name, $arguments)
    {
        $class = __NAMESPACE__ . '\\Requests\\' . studly_case($name) . "Request";
        if (class_exists($class)) {
            $app = app()->make($class);
            return $app->handle(...$arguments);
        }

        throw new \Exception("{$name} not found");
    }
}