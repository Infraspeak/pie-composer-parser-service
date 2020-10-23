<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TestMessageQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:test:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to test messages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // REPO_*
        Redis::psubscribe([env('REPO_TOPIC') . '*'], function($message) {
            dump($message);
        });
    }
}
