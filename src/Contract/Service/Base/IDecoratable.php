<?php

namespace App\Contract\Service\Base;


interface IDecoratable
{
    public function decoratorRoot($instance);
}