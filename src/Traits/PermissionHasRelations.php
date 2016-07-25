<?php

namespace Saguajardo\BootstrapMenu\Traits;

trait PermissionHasRelations
{
    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('bootstrap-menu.models.role'), config('bootstrap-menu.relations.permission_role'))->withTimestamps();
    }

    /**
     * Permission belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('bootstrap-menu.models.user'), config('bootstrap-menu.relations.permission_user'))->withTimestamps();
    }
}
