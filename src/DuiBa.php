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
    protected $config = [];

    public function __construct()
    {
        $this->config = config("duiba");
    }

    public function __call($name, $arguments)
    {
        $class = __NAMESPACE__ . '\\Requests\\' . studly_case($name);
        if (class_exists($class)) {
            $builder = app()->make($class);
            return $builder->handle(...$arguments);
        }

        throw new \Exception("{$name} not found");
    }
}