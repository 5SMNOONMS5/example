<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Stephenchen\Banner\Http\Backend\Banner\BannerModel;

class BannerModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BannerModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'path'  => 'uploads/20220306/sample2-62253ee753c7b.png',
        ];
    }
}
