<?php

namespace App\Http\Controllers\Api;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class RegController extends Controller
{
    public function reg(Request $request){
        $tel = $request->input('tel');
        $nickname = $request->input('nickname');
        $password1 = $request->input('password1');
        $password2 = $request->input('password2');
        $email = $request->input('email');

        //验证密码
        if ($password1 != $password2){
            $response = [
                'errno' =>  50002,
                'msg'   =>  '密码不一致',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //验证邮箱
        $em = UserModel::where(['email'=>$email])->first();
        if($em){
            $response = [
                'errno' =>  50003,
                'msg'   =>  '邮箱已存在',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //验证账号
        $name = UserModel::where(['nickname'=>$nickname])->first();
        if($name){
            $response = [
                'errno' =>  50004,
                'msg'   =>  '账号名称已存在',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //密码加密
        $password = password_hash($password1,PASSWORD_BCRYPT);

        $info = [
            'nickname'   =>  $nickname,
            'email'      =>  $email,
            'password'   =>  $password,
            'tel'        =>  $tel,
            'create_time'=>  time()
        ];
        //注册成功  入库
        $add = UserModel::insertGetId($info);
        if ($add){
            $response = [
                'errno' =>  50001,
                'msg'   =>  'ok',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $arr = UserModel::where(['email'=>$email])->first();
        if ($arr){

            if (password_verify($password,$arr->password)){

                $token = $this->token($arr->id);
                $token_key = 'token:id' .$arr->id;
                Redis::set($token_key,$token);
                Redis::expire($token_key,604801);
            }

            $response = [
                'errno' => 0,
                'msg'   => 'ok',
                'data'  => [
                    'token' => $token
                ]
            ];

            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $response = [
                'errno' =>  50005,
                'msg'   =>  '邮箱不正确',
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));

        }
    }

    //设置token值
    protected function token($id){
        $token = substr(sha1($id . time() . Str::random(10)),5,20);
        return $token;
    }

    public function my(){

    }
}
