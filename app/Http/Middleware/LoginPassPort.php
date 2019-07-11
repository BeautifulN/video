<?php

namespace App\Http\Middleware;

use Closure;

class LoginPassPort
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

        if (empty($_COOKIE['token']) || empty($_COOKIE['id'])){
            header("refresh:3;url=http://pass.1809a.com/log");
            $response = [
                'errno'  =>  '40010',
                'msg'    =>  '请先登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $key = 'token:id' . $_COOKIE['id'];
            $redis_token = Redis::get($key);
            if ($redis_token == $_COOKIE['token']){
                //TODO 登录成功
                $response = [
                    'errno'  =>  0,
                    'msg'    =>  '登录成功'
                ];


                die(json_encode($response,JSON_UNESCAPED_UNICODE));

            }else{
                //TODO token需要授权
                $response = [
                    'errno'  =>  '40010',
                    'msg'    =>  '请先登录'
                ];
                header("refresh:3;url=http://pass.1809a.com/log");
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }

        return $next($request);
    }
}
