<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sourcesteering extends Model
{
    protected $table = 'sourcesteering';

    /**
     * @return boolean
     */
    public function getIdByCode($code)
    {
        $steering      = self::where('code',$code);
        $steering_id   = $steering->id;

        return $steering_id;
    }
}
