# bootstrap-menu
Provee el paquete completo de la administración de permisos y menús, con ABM de Usuarios, Perfiles y Permisos

Se debe incluir el siguiente Provider:

Saguajardo\BootstrapMenu\BootstrapMenuServiceProvider::class,

Alias:

'BootstrapMenu'=> Saguajardo\BootstrapMenu\Facades\BootstrapMenuFacade::class,
'BootstrapMenuBuilder'=> Saguajardo\BootstrapMenu\BootstrapMenuBuilder::class,

Publicar el archivo de configuración y las migraciones

php artisan vendor:publish --provider="Saguajardo\BootstrapMenu\BootstrapMenuServiceProvider"

Agregar el siguiente método en el archivo vendor\laravel\framework\src\Illuminate\Foundation\Auth\User.php

use Saguajardo\BootstrapMenu\Traits\HasRoleAndPermission;
use Saguajardo\BootstrapMenu\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Model implements
    AuthenticatableContract,
    HasRoleAndPermissionContract, // <----
    CanResetPasswordContract
{
    use Authenticatable, HasRoleAndPermission, CanResetPassword;
}


