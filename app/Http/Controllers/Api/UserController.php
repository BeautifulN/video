<?php

namespace App\Http\Controllers\Api;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function user()
    {
        $id = $_GET['id'];
        $api = UserModel::where(['id' => $id])->first()->toArray();
        $data = [];
        $data = [
            'error' => 0,
            'msg'   => 'ok',
            'data' => [
                'api' => $api,
            ]
        ];

        var_dump($data);
    }

    //post
    public function index(Request $request){
        $data=[
            'nickname'=>'李四',
            'age'=>1,
        ];
        UserModel::insertGetId($data);
        $info=[
            'error'=>0,
            'msg'=>'ok'
        ];
        print_r($info);

    }

    public function indexadd(){
//        echo __METHOD__;
        print_r($_POST);
        $str = file_get_contents("php://input");
        echo 'str:'.$str;
    }

}
