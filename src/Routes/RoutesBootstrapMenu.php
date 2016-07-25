<?php namespace Saguajardo\BootstrapMenu\Routes;

class RoutesBootstrapMenu
{
    /**
     * Indicate that the routes that are defined in the given callback
     * should be cached.
     *
     * @return string
     */
    static public function getRoutes()
    {
        // Route for seguridad/permisos
        app('router')->get('/seguridad/permisos', [
            'as' => 'permisos',
            'middleware' => 'permission:seguridad.permisos',
            'uses' => 'SeguridadController@getPermisos',
        ]);

        // Route for seguridad/permisos
        app('router')->get('/seguridad/usuarios-listado', [
            'uses' => 'SeguridadController@getUsuariosListado',
        ]);

        // Route form seguridad/perfiles
        app('router')->get('/seguridad/perfiles', [
            'as' => 'perfiles',
            'middleware' => 'permission:seguridad.perfiles',
            'uses' => 'SeguridadController@getPerfiles',
        ]);

        app('router')->get('/seguridad/usuarios', [
            'as' => 'usuarios',
            'middleware' => 'permission:seguridad.usuarios',
            'uses' => 'SeguridadController@getUsuarios',
        ]);

    }

}