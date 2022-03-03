<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stephenchen\Banner\Http\Backend\Banner\BannerModel;

class BannerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        BannerModel::factory(10)->create();
    }
}
