<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Connection
    |--------------------------------------------------------------------------
    |
    | You can set a different database connection for this package. It will set
    | new connection for models Role and Permission. When this option is null,
    | it will connect to the main database, which is set up in database.php
    |
    */

    'connection' => null,

    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Here you can change the slug separator. This is very important in matter
    | of magic method __call() and also a `Slugable` trait. The default value
    | is a dot.
    |
    */

    'separator' => '.',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you want, you can replace default models from this package by models
    | you created. Have a look at `Saguajardo\BootstrapMenu\Models\Role` model and
    | `Saguajardo\BootstrapMenu\Models\Permission` model.
    |
    */

    'models' => [
        'user' => App\User::class,
        'role' => Saguajardo\BootstrapMenu\Models\Role::class,
        'permission' => Saguajardo\BootstrapMenu\Models\Permission::class,
        'menu' => Saguajardo\BootstrapMenu\Models\MenuModel::class,
    ],

    'relations' => [
        'role_user' => 'd_biods_v.role_user',
        'permission_role' => 'd_biods_v.permission_role',
        'permission_user' => 'd_biods_v.permission_user',
    ],

    'tables' => [
        'permissions' => 'd_biods_v.permissions',
        'roles' => 'd_biods_v.roles',
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles, Permissions and Allowed "Pretend"
    |--------------------------------------------------------------------------
    |
    | You can pretend or simulate package behavior no matter what is in your
    | database. It is really useful when you are testing you application.
    | Set up what will methods is(), can() and allowed() return.
    |
    */

    'pretend' => [

        'enabled' => false,

        'options' => [
            'is' => true,
            'can' => true,
            'allowed' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Styles Menu
    |--------------------------------------------------------------------------
    |
    | You can set a different styles for this package. It will set
    | new styles to be applied in the menu.
    |
    */

    'classUl'           => 'sidebar-menu',
    'optionsUl'         => '',


    // 'model'             => '\Saguajardo\BootstrapMenu\Models\MenuModel',

    /*
    |--------------------------------------------------------------------------
    | Templates Menu
    |--------------------------------------------------------------------------
    |
    | You can set a different templates for this package. It will set
    | templates to views.
    |
    */

    'menu_template'     => 'bootstrap-menu::menu',
];
