# bootstrap-menu
Provee el paquete completo de la administración de permisos y menús, con ABM de Usuarios, Perfiles y Permisos

Para instalarlo, incluir lo siguiente en composer.json de tu proyecto:

``` json
{
    "require": {
        "saguajardo/bootstrap-menu": "dev-master"
    }
}
```

Ejecutar `composer update`

Se debe incluir el siguiente Provider:

``` php
    'providers' => [
        // ...
        Saguajardo\BootstrapMenu\BootstrapMenuServiceProvider::class,
    ]
```

Alias:

``` php
    'aliases' => [
        // ...
        'BootstrapMenu'=> Saguajardo\BootstrapMenu\Facades\BootstrapMenuFacade::class,
        'BootstrapMenuBuilder'=> Saguajardo\BootstrapMenu\BootstrapMenuBuilder::class,
    ]

```

Publicar el archivo de configuración y las migraciones

`php artisan vendor:publish --provider="Saguajardo\BootstrapMenu\BootstrapMenuServiceProvider"`



Agregar el siguiente método en el archivo vendor\laravel\framework\src\Illuminate\Foundation\Auth\User.php

```php
use Saguajardo\BootstrapMenu\Traits\HasRoleAndPermission;
use Saguajardo\BootstrapMenu\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Model implements
    AuthenticatableContract,
    HasRoleAndPermissionContract, // <----
    CanResetPasswordContract
{
    use Authenticatable, HasRoleAndPermission, CanResetPassword;
}
```
