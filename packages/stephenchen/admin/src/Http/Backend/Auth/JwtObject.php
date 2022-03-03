<?php

namespace Stephenchen\Admin\Http\Backend\Auth;

use Exception;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

final class JwtObject
{
    /**
     * @string
     */
    protected string $token;

    /**
     * @var
     */
    protected $payload;

    /**
     * AuthObject constructor.
     *
     * @param $token
     *
     * @throws Exception
     */
    public function __construct($token)
    {
        $this->setToken($token);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getExpiredAt()
    {
        $exp = $this->getPayload()->get('exp');
        return Carbon::createFromTimestamp($exp)->toDateTimeString();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getPayload()
    {
        if (!$this->payload) {
            $this->payload = JWTAuth::setToken($this->getToken())->getPayload();
        }

        return $this->payload;
    }

    /**
     * @param object $payload
     *
     * @return JwtObject
     */
    public function setPayload($payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getRefreshExpiredAt()
    {
        $iat = $this->getPayload()->get('iat');
        return Carbon::createFromTimestamp($iat)
            ->addMinutes(config('jwt.refresh_ttl'))
            ->toDateTimeString();
    }
}
