<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAccountSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account_settings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix account settings typo errors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
