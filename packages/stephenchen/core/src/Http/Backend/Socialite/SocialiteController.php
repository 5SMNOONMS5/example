<?php

namespace Stephenchen\Core\Http\Backend\Socialite;

use Stephenchen\Core\Base\BaseController;
use Illuminate\Http\JsonResponse;

/**
 * Class SocialiteController
 *
 * @package App\Http\Backend\Socialite
 */
final class SocialiteController extends BaseController
{
    /**
     * @var SocialiteService
     */
    private SocialiteService $socialiteService;

    /**
     * SocialiteController constructor.
     *
     * @param SocialiteService $socialiteService
     */
    public function __construct(SocialiteService $socialiteService)
    {
        $this->socialiteService = $socialiteService;
    }

    /**
     * Display a listing of the resource
     *
     * @return JsonResponse
     */
    public function index()
    {
        $result = $this->socialiteService->index();
        return parent::jsonSuccess(config('message.success.default'), $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SocialiteRequest $request
     *
     * @return JsonResponse
     */
    public function createOrUpdate(SocialiteRequest $request)
    {
        $result = $this->socialiteService->createOrUpdate($request->all());

        return ( $result )
            ? parent::jsonSuccess(config('message.success.store'), $result)
            : parent::jsonFail(config('message.fail.store'), $result);
    }
}
