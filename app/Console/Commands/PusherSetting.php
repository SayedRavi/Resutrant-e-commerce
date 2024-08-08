<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class PusherSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pusher:setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates initial pusher api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Setting::updateOrCreate(
                ['key' => 'pusher_app_id'],
                ['value' => '1835074']
        );
        Setting::updateOrCreate(
            ['key' => 'pusher_key'],
            ['value' => '5e4b5d3ed167f0a7fc33']
        );
        Setting::updateOrCreate(
            ['key' => 'pusher_secret'],
            ['value' => 'f97fa27efe84d5cc640a']
        );Setting::updateOrCreate(
                ['key' => 'pusher_cluster'],
                ['value' => 'mt1']
         );

        $this->info('Created pusher setting');
    }
}
