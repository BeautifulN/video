<?php

namespace App\Http\Controllers\Login;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //登录展示
    public function log()
    {
        return view('login.login');
    }

    //登录
    public function log_cookie(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $arr = UserModel::where(['email' => $email])->first();
        if ($arr) {

            if (password_verify($password, $arr->password)) {

                $token = $this->token($arr->id);
                $token_key = 'token:id' . $arr->id;
                Redis::set($token_key, $token);
                Redis::expire($token_key, 604801);

                setcookie('token',$token,time()+720,'/','1809a.com',false,true);
                setcookie('id',$arr->id,time()+720,'/','1809a.com',false,true);
                header("refresh:3;url=http://api.1809a.com");
                $response = [
                    'errno' => 456413131,
                    'msg' => 'ok',
                    'token' => $token
                ];
                die(json_encode($response, JSON_UNESCAPED_UNICODE));

            }else{
                $response = [
                    'errno' => 50008,
                    'msg' => '密码错误',
                ];
                die(json_encode($response, JSON_UNESCAPED_UNICODE));
            }

        }else{
            $response = [
                'errno' => 50005,
                'msg' => '邮箱不正确',
            ];
            die(json_encode($response, JSON_UNESCAPED_UNICODE));

        }
    }


    //设置token值
    protected function token($id){
        $token = substr(sha1($id . time() . Str::random(10)),5,20);
        return $token;
    }
}
