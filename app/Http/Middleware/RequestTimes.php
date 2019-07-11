<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class RequestTimes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        echo date('Y-m-d H:i:s');
        $key = 'token:ip:' . $_SERVER['REMOTE_ADDR'] . 'token:' . $request->input('token');
        $arr = Redis::get($key);
//        var_dump($arr);
        if ($arr > 5){
            $response = [
                'errno' => 50007,
                'msg'   => '超出次数限制',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $res = Redis::incr($key);
        var_dump($res);
        Redis::expire($key,30);

        return $next($request);
    }
}
