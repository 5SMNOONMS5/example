<?php

namespace Stephenchen\Admin\Http\Backend\Role;

use Database\Factories\RoleModelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;
use Stephenchen\Core\Traits\Model\SerializeDateTrait;

class RoleModel extends BaseRole
{
    use SerializeDateTrait,
        HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'guard_name',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return RoleModelFactory::new();
    }
}
