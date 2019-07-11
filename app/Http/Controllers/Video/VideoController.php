<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use OSS\Core\OssException;
use OSS\OssClient;

class VideoController extends Controller
{
    protected $accessKeyId = "LTAI2sznOiLK1drL";   //
    protected $accessKeySecret = "BJxwVzYHrV9MbALIxnuRtzOweIRrhQ";
    protected $Bucket = '1809-video';

    /*
     * 本地文件视频转移到 OSS
     * */
    public function Oss_video()
    {
        //视频转移成功后，删除本地文件
        $ossClient = new OssClient($this->accessKeyId,$this->accessKeySecret,env('ALI_OSS_ENDPOINT'));

        //获取当前目录中的文件
        $file_path = public_path('uploads/files');
        $file_list = scandir($file_path);

        foreach ($file_list as $k=>$v){
            if ($v== '.' || $v=='..'){
                continue;
            }

            $file_name = Str::random(5). '.jpg';
            $local_file = $file_path . '/' .$v;

            echo "本地文件：".$local_file;echo '<br>';

            try{
                $ossClient->uploadFile($this->Bucket,$file_name,$local_file);
            } catch (OssException $e){
                printf(__FUNCTION__ . "：FAILED\n");
                printf($e->getMessage(). "\n");
                return;
            }

            //上传成功后 删除本地文件
            echo $local_file . '上传成功';echo '<hr>';
            unlink($local_file);

            
        }

        
    }
}
