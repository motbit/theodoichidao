<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 5/9/2017
 * Time: 11:36 AM
 */

namespace App;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class MLogs
{
    public static function write($action_name, $action_object, $action_obj_id, $description)
    {
        try {
            DB::connection('mysql_logs')->table('logs')
                ->insert([
                    'action_name' => $action_name,
                    'action_object' => $action_object,
                    'action_user' => Auth::user()->username,
                    'action_obj_id' => $action_obj_id,
                    'description' => $description
                ]);
        } catch (Exception $e) {

        }
    }
}