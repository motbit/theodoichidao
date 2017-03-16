<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Viphuman extends Model
{
    protected $table = 'viphuman';

    public static function findAll($key){
        $sql = 'SELECT viphuman.id, viphuman.name, function.description
                FROM viphuman JOIN function
                WHERE viphuman.function = function.id
                AND viphuman.name like "%' .$key .'%"';

        $data = DB::select($sql);
        return $data;
    }

}
