<?php

namespace Stephenchen\Member\Http\Backend;

use Database\Factories\MemberModelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Stephenchen\Core\Traits\Model\SerializeDateTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class MemberModel extends Authenticatable implements JWTSubject
{
    use Notifiable,
        SoftDeletes,
        HasFactory,
        HasRoles,
        SerializeDateTrait;

    protected $guard_name = 'users';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "members";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'account',
        'email',
        'password',
        'display_name',
        'status',
        'latest_ip',
        'latest_login_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'latest_login_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Mutator Password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes[ 'password' ] = bcrypt($value);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return MemberModelFactory::new();
    }
}
