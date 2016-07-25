<?php

namespace Saguajardo\BootstrapMenu\Models;

use Saguajardo\BootstrapMenu\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Saguajardo\BootstrapMenu\Traits\RoleHasRelations;
use Saguajardo\BootstrapMenu\Contracts\RoleHasRelations as RoleHasRelationsContract;
use Exception;

class Role extends Model implements RoleHasRelationsContract
{
    use Slugable, RoleHasRelations;

    protected $table = 'd_biods_v.roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'level'];

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

            $date = Role::max('created_at');
            $id = Role::select('id')->where('created_at', $date)->first();
            $role = Role::find($id);

            return $role;

        } catch(Exception $e) {
            
            if($e->getCode() != 'IM001'){
                return $e;
            }

            $date = Role::max('created_at');
            $roleId = Role::select('id')->where('created_at', $date)->first();
            $role = Role::find($roleId->id);

            return $role;
        }
        
    }
}
