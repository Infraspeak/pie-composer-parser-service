<?php

namespace App\Console\Commands;

use App\Parsers\ComposerFileParser;
use App\Repositories\RedisMessageRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class PubSub extends Command
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
    protected $description = 'Listens and dispatches Redis messages';

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
                    $message = json_decode($message, true);
                    try {
                        RedisMessageRepository::publish(
                            ComposerFileParser::parse($message['payload']),
                            $message['headers']
                        );
                    }
                    catch (\Exception $e){
                        $error = [
                            "code" => $e->getCode(),
                            "description" => $e->getMessage()
                        ];

                        RedisMessageRepository::publishError($error,
                            $message['headers']
                        );
                    }
                });
        }
}
