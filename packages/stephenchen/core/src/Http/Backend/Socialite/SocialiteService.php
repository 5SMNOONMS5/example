<?php

namespace Stephenchen\Core\Http\Backend\Socialite;

/**
 * Class SocialiteService
 *
 * @package App\Http\Backend\Socialite
 */
final class SocialiteService
{
    /**
     * @var SocialiteRepositoryInterface
     */
    private SocialiteRepositoryInterface $repository;

    /**
     * SocialiteService constructor.
     *
     * @param SocialiteRepositoryInterface $repository
     */
    public function __construct(SocialiteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource
     */
    public function index(): array
    {
        return $this->repository->all()->toArray();
    }

    /**
     * Create or update model
     *
     * @param array $parameters
     *
     * @return array
     */
    public function createOrUpdate(array $parameters): ?array
    {
        foreach ($parameters as $parameter) {
            $this->repository
                ->findWhere([
                    'provider' => $parameter[ 'provider' ],
                ])
                ->first()
                ->update($parameter);
        }

        return $this->index();
    }
}
