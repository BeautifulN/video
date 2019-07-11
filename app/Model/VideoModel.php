<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VideoModel extends Model
{
    protected $table='videos';

    public $timestamps = false;

    protected  $primaryKey="id";
}
