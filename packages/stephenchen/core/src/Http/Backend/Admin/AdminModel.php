<?php

namespace Stephenchen\Core\Http\Backend\Admin;

use Database\Factories\AdminModelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Stephenchen\Core\Traits\Model\SerializeDateTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     title="AdminModel",
 *     required= {
 *          "name",
 *          "photoUrls"
 *     },
 *     @OA\Xml(
 *         name="AdminModel",
 *     )
 * )
 */
final class AdminModel extends Authenticatable implements JWTSubject
{
    /**
     * @OA\Property(
     *     format="string",
     *     example="account"
     * )
     * @var string
     */
    private string $account;

    /**
     * @OA\Property(
     *     format="string",
     *     example="xxxx@gamil.com"
     * )
     * @var string
     */
    protected string $email;

    /**
     * @OA\Property(
     *     format="string",
     *     example="password111",
     *     description="默認是驗證格式是 `數字` + `大寫英文` + `小寫英文` + `開頭是否是英文` + `下底線` + `橫線`"
     * )
     * @var string
     */
    private string $password;

    /**
     * @OA\Property(
     *     format="string",
     *     example="password111"
     * )
     * @var string
     */
    private string $password_confirmation;

    /**
     * @OA\Property(
     *     format="string",
     *     example="小虎"
     * )
     * @var string
     */
    private string $display_name;

    /**
     * @OA\Property(
     *     format="integer",
     *     description="狀態，可能會有 0 ~ 127",
     *     example="0"
     * )
     * @var string
     */
    private string $status;

    /**
     * @OA\Property(
     *     format="integer",
     *     example="1"
     * )
     * @var string
     */
    private string $role_id;

    use Notifiable,
        SoftDeletes,
        HasFactory,
        HasRoles,
        SerializeDateTrait;

    protected $guard_name = 'admins';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "admins";

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
        'password', 'remember_token', 'deleted_at',
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
        return AdminModelFactory::new();
    }
}
