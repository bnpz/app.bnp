<?php

namespace App\Mixin;

trait CanInitialise
{
    /**
     * @return static
     */
    public static function init()
    {
        return new static();
    }
}