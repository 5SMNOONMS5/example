<?php

namespace Stephenchen\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Stephenchen\Core\Utilities\Helpers;

final class InitialCommandPart1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:initial-part1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[ Custom ] All in one init';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Application all in one [ Part 1 ]');
        $this->maybeCopyEnvFile();
        $this->maybeGenerateAppKey();
        $this->maybeGenerateJwtSecret();
        $this->createStorageLink();
        $this->publicL5SwaggerDocumentation();
        $this->publicPermissions();
//        $this->maybeMigrateTable();
//        $this->maybePublishLaravelHorizon();
    }

    /**
     * Copy .env.example to .env
     */
    private function maybeCopyEnvFile(): void
    {
        $this->info('[ 準備 ] 新增 .env 檔案');
        if (!file_exists('.env')) {
            File::copy(base_path('.env.example'), base_path('.env'));

            // @TODO:
            // 把 env 檔案的值清空，方便讓 auto_web_deploy 腳本去替換，又或者讓這個 command 可以接受來自
            // 架站腳本的值，
            Helpers::updatePermanentEnvValue('DB_PREFIX', '');
            Helpers::updatePermanentEnvValue('DB_USERNAME', '');
            Helpers::updatePermanentEnvValue('DB_PASSWORD', '');
            Helpers::updatePermanentEnvValue('DB_DATABASE', '');

            $this->info('[ 完成 ] 新增 .env 檔案, 請把相關資訊填寫');
        } else {
            $this->comment('[ 忽略 ] .env 檔案已經存在');
        }
    }

    /**
     * 創建 Application key
     */
    private function maybeGenerateAppKey(): void
    {
        $this->info('[ 準備 ] 創建 Application Key');
        if (!env('APP_KEY')) {
            $this->call('key:generate');
            $this->info('[ 完成 ] 創建 Application Key');
        } else {
            $this->comment('[ 忽略 ] Application key');
        }
    }

    /**
     * 產生 jwt secret 的 key
     */
    private function maybeGenerateJwtSecret(): void
    {


        $this->info('[ 準備 ] 創建 JWT secret key');
        if (!env('JWT_SECRET')) {
            Artisan::call('jwt:secret');
            Artisan::call('vendor:publish', [
                '--provider' => 'Tymon\JWTAuth\Providers\LaravelServiceProvider',
            ]);
            $this->info('[ 完成 ] 創建 JWT secret key');
        } else {
            $this->comment('[ 忽略 ] JWT secret key');
        }
    }

    /**
     * Maybe migrate table
     *
     * @return void
     */
    public function maybeMigrateTable(): void
    {
        $this->info('[ 準備 ] migrate:refresh --seed');
        Artisan::call('migrate:refresh --seed');
        $this->info('[ 完成 ] migrate:refresh --seed');
    }

    /**
     * Publish laravel horizon
     * cf. https://laravel.com/docs/8.x/horizon
     */
    private function maybePublishLaravelHorizon()
    {
        $this->info('[ 準備 ] publish laravel horizon assets');
        $isExist = config()->has('horizon');

        if (!$isExist) {
            Artisan::call('horizon:install');
            $this->info('[ 完成 ] publish laravel horizon assets');
        } else {
            $this->comment('[ 忽略 ] publish laravel horizon assets 檔案已經存在');
        }
    }

    /**
     * 連結 storage link
     */
    private function createStorageLink(): void
    {
        $this->info('[ 準備 ] 創建 連結 storage link');
        if (!App::environment('local')) {
            $this->call('storage:link');
            $this->info('[ 完成 ] 創建 連結 storage link');
        } else {
            $this->comment('[ 忽略 ] local 環境不創建 storage link');
        }
    }

    /**
     * Publish apidoc.php for API Documentation
     * https://github.com/DarkaOnLine/L5-Swagger/wiki/Installation-&-Configuration
     */
    private function publicL5SwaggerDocumentation(): void
    {
        $this->info('[ 準備 ] publish l5-swagger 相關的檔案');
        $parameters = config()->get('l5-swagger') ?? [];

        if (!isset($parameters)) {
            Artisan::call('vendor:publish', [
                '--provider' => 'L5Swagger\L5SwaggerServiceProvider',
            ]);
            $this->info('[ 完成 ] publish l5-swagger.php 到 config 路徑底下');
            $this->info('[ ！！！ ] 請到 config/l5-swagger.php 底下把參數填好填滿');
        } else {
            $this->comment('[ 忽略 ] publish l5-swagger.php, 檔案已經存在');
        }
    }

    private function publicPermissions()
    {
        $this->info('[ 準備 ] publish spatie-permission 相關的檔案');
        $parameters = config()->get('permission') ?? [];

        if (!isset($parameters)) {
            Artisan::call('vendor:publish', [
                '--provider' => 'Spatie\Permission\PermissionServiceProvider',
            ]);
            $this->info('[ 完成 ] publish permission.php 到 config 路徑底下');
            $this->info('[ ！！！ ] 請到 config/permission.php 底下把參數填好填滿');
        } else {
            $this->comment('[ 忽略 ] publish permission.php, 檔案已經存在');
        }
    }
}
