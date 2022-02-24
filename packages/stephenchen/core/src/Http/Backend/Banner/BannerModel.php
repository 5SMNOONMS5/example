<?php

namespace Stephenchen\Core\Http\Backend\Banner;

use Database\Factories\BannerModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     description="BannerModel 物件",
 *     @OA\Xml(
 *         name="BannerModel"
 *     )
 * )
 */
final class BannerModel extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     format="string",
     *     example="name"
     * )
     * @var string
     */
    private string $title;

    /**
     * @OA\Property(
     *     format="integer",
     *     example="status"
     * )
     * @var string
     */
    private string $status;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'subtitle',
        'synopsis',

        'is_enabled',

        'created_at',
        'updated_at',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return BannerModelFactory
     */
    protected static function newFactory()
    {
        return BannerModelFactory::new();
    }
}
