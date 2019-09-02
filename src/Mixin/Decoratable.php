<?php

namespace App\Mixin;


trait Decoratable
{
    protected $instance;

    /**
     * @param $instance
     */
    protected function setInstance($instance)
    {
        $this->instance = $instance;
    }

    public function decoratorRoot($instance)
    {
        $this->setInstance($instance);
    }

}