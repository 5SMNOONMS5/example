<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Stephenchen\Core\Http\Backend\Admin\AdminModel;

class AdminModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdminModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account'         => $this->faker->name(),
            'email'           => $this->faker->email(),
            'password'        => 'a111111',
            'display_name'    => $this->faker->firstName(),
            'status'          => $this->faker->numberBetween(0, 2),
            'latest_ip'       => $this->faker->ipv4(),
            'latest_login_at' => $this->faker->time(),
        ];
    }
}
