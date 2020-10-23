<?php

namespace App\Console\Commands;

use App\Parsers\ComposerFileParser;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ListenToQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to Queue!?';

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
        Redis::connection('subscribe')
            ->subscribe([env('MESSAGE_TOPIC')], function ($message) {
                dump($message);
                ComposerFileParser::parse($message);
            });
    }
}
