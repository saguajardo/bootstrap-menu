<?php

namespace Saguajardo\BootstrapMenu\Facades;

use Illuminate\Support\Facades\Facade;

class BootstrapMenuFacade extends Facade {

    public static function getFacadeAccessor()
    {
        return 'bootstrap-menu';
    }
}
