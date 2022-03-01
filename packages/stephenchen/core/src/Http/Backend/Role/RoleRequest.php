<?php

namespace Stephenchen\Core\Http\Backend\Role;

use Illuminate\Validation\Rule;
use Stephenchen\Core\Base\BaseRequest;
use Stephenchen\Core\Http\Backend\Permission\PermissionRepositoryInterface;

class RoleRequest extends BaseRequest
{
    /**
     * @var PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository,
                                array $query = [],
                                array $request = [],
                                array $attributes = [],
                                array $cookies = [],
                                array $files = [],
                                array $server = [],
                                $content = NULL)
    {
        $this->permissionRepository = $permissionRepository;
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Permission IDs came from user
        $permissionIDs = $this->get('permission_ids');

        $collections = $this->permissionRepository->select(['id', 'parent_id'])->get();
        $ids         = $collections->pluck('id')->toArray();

        $diffs = collect($permissionIDs)->diff($ids)->count();

//        dd($diffs);

        $this->merge([
            'is_validate_permission_ids' => $diffs,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('role');

        return [
            'name'                       => [
                'required',
                Rule::unique('roles', 'name')->ignore($id),
            ],
            'permission_ids'             => 'array',
            'is_validate_permission_ids' => 'lte:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $name = ['key' => '角色'];

        return [
            'name.required'                  => trans('core::global.validation.required', $name),
            'name.unique'                    => trans('core::global.validation.unique', $name),
            'is_validate_permission_ids.lte' => trans('core::global.unprocessable_permission'),
        ];
    }
}
