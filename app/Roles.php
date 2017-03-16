<?php
/**
 * Created by PhpStorm.
 * User: Windows 10 Gamer
 * Date: 16/03/2017
 * Time: 4:47 CH
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Roles extends Model
{
    public static function checkPermission(){
        $user = Auth::user();
        if ($user->group == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function requireAuthen(){
        if (!Auth::check()){
            return redirect("login");
        }
    }
}