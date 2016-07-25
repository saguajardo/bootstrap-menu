<?php

use Saguajardo\BootstrapMenu\BootstrapMenuBuilder;
use Saguajardo\BootstrapMenu\BootstrapMenuHelper;

if (!function_exists('bootstrap-menu')) {

    function bootstrapMenu()
    {
        $bootstrapMenu = App::make('bootstrap-menu')->create(\Saguajardo\BootstrapMenu\BootstrapMenu::class);
        return $bootstrapMenu->renderBootstrapMenu();
    }

}

if (!function_exists('bootstrap-menu-routes')) {

    function bootstrapMenuRoutes()
    {
        $bootstrapMenuRoutes = App::make('bootstrap-menu-routes')->getRoutes();
    }

}
