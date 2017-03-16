<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chucnang extends Model
{
    protected $table = 'function';

    public static function findAll(){
        $sql = "Select id, name, description from function";
        $data = DB::select($sql);
        return $data;
    }

}
