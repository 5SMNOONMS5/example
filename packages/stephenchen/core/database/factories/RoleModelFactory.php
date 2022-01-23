<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Stephenchen\Core\Http\Backend\Role\RoleModel;

class RoleModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
