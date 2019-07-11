<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $arr = DB::table('videos')->get();
//        var_dump($arr);
        return view('video.index',['arr'=>$arr]);
    }
}
