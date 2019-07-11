<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckToken
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
        $token = $request->input('token');
        $id = $request->input('id');

        //验证参数是否完整
        if (empty($token) || empty($id)){
            $response = [
                'errno' =>  40002,
                'msg'   =>  '参数不完整',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        
//        if ($token == NULL){
//            $response = [
//                'errno' =>  40003,
//                'msg'   =>  '未授权',
//            ];
//            die(json_encode($response,JSON_UNESCAPED_UNICODE));
//        }

        //验证token是否有效
        $key = 'token:id' . $id;
        $redis_token = Redis::get($key);

        if ($redis_token){
            //TODO 登录成功
            if ($token == $redis_token){
                //TODO 记录日志 token有效

            }else{
                $response = [
                    'errno'  =>  '40004',
                    'msg'    =>  'token值无效'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            //TODO token需要授权
            $response = [
                'errno'  =>  '40005',
                'msg'    =>  '请先登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        
        return $next($request);
    }
}
