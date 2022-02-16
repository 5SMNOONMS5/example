<?php

namespace Stephenchen\Core\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Stephenchen\Core\Http\Backend\Role\RoleModel;

final class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:test';

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
        $this->info('This is test command');


        return 0;
    }

}
