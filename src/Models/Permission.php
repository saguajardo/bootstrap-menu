<?php

namespace Saguajardo\BootstrapMenu\Models;

use Saguajardo\BootstrapMenu\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Saguajardo\BootstrapMenu\Traits\PermissionHasRelations;
use Saguajardo\BootstrapMenu\Contracts\PermissionHasRelations as PermissionHasRelationsContract;
use Exception;


class Permission extends Model implements PermissionHasRelationsContract
{
    use Slugable, PermissionHasRelations;

    protected $table = 'd_biods_v.permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'model'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($connection = config('bootstrap-menu.connection')) {
            $this->connection = $connection;
        }
    }

    protected static function Guardar(array $data) {
        $model = new static($data);


        /**
         * TODO: Modificar la funcion guardar para mysql, debido a que no da error!!
         * Debería devolver el ID correctamente.
         */


        try {
            $model->save();

            $date = Permission::max('created_at');
            $id = Permission::select('id')->where('created_at', $date)->first();
            $permission = Permission::find($id);

            return $permission;

        } catch(Exception $e) {
            
            if($e->getCode() != 'IM001'){
                return $e;
            }

            $date = Permission::max('created_at');
            $permissionId = Permission::select('id')->where('created_at', $date)->first();
            $permission = Permission::find($permissionId->id);

            return $permission;
        }
        
    }


}
