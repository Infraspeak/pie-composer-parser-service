<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisMessageController extends Controller
{
    public function __invoke(Request $request)
    {
        Redis::publish('COMPOSER_FILE', $request->getContent());
    }
}
