<?php

namespace Stephenchen\Core\Http\Backend\Socialite;

use Stephenchen\Core\Traits\Model\EnableTrait;
use Illuminate\Database\Eloquent\Model;
use Stephenchen\Core\Traits\Model\SerializeDateTrait;

/**
 * Class SocialiteModel
 *
 * @package App\Http\Backend\Socialite;
 */
final class SocialiteModel extends Model
{
    use SerializeDateTrait,
        EnableTrait;

    const SOCIALITES_FACEBOOK  = 'facebook';
    const SOCIALITES_INSTAGRAM = 'instagrm';
    const SOCIALITES_YOUTUBE   = 'youtube';
    const SOCIALITES_LINE      = 'line';
    const SOCIALITES_TWITTER   = 'titter';
    const SOCIALITES_WECHAT    = 'wechat';
    const SOCIALITES_WHATSAPP  = 'whatapp';
    const SOCIALITES_LINKEDIN  = 'linkedin';
    const SOCIALITES_GOOGLE    = 'google';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'socialites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_secret',
        'channel_id',
        'callback_urls',

        'complement',
        'provider',

        'is_enabled',

        'created_at',
        'updated_at',
    ];

    /**
     * Return all socialite provider
     *
     * @return array
     */
    public function getProviders(): array
    {
        return [
            self::SOCIALITES_FACEBOOK,
            self::SOCIALITES_INSTAGRAM,
            self::SOCIALITES_YOUTUBE,
            self::SOCIALITES_LINE,
            self::SOCIALITES_TWITTER,
            self::SOCIALITES_WECHAT,
            self::SOCIALITES_WHATSAPP,
            self::SOCIALITES_LINKEDIN,
            self::SOCIALITES_GOOGLE,
        ];
    }
}
