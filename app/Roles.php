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
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    public static function checkPermission()
    {
        $user = Auth::user();
        if ($user->group == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function makePath($path)
    {
        if ($path == '' || $path == 'home' || $path == '/') {
//            $path = 'sourcesteering';
            $path = 'steeringcontent';
        }
        return $path;
    }

    public static function accessView($path)
    {
        $path = self::makePath($path);
        $check = DB::table('views')
            ->join('group_permission', 'group_permission.view', '=', 'views.id')
            ->where([
                ['views.path', 'like', $path],
                ['group_permission.group', '=', Auth::user()->group]
            ])
            ->get();
        if (count($check) == 0) {
            return false;
        } else {
            return $check[0];
        }
    }

    public static function accessAction($role, $action)
    {
        return (strpos($role->action, '(' . $action . ')') !== false);
    }

    public static function requireAuthen()
    {
        if (!Auth::check()) {
            return redirect("login");
        }
    }

    public static function getMenu($parent)
    {
        if (!Auth::check()) {
            return redirect("login");
        } else {
            $menu = DB::table('views')
                ->join('group_permission', 'group_permission.view', '=', 'views.id')
                ->where([
                    ['views.parent', 'like', $parent],
                    ['group_permission.group', '=', Auth::user()->group]
                ])
                ->orderBy('_order', 'ASC')
                ->select('views.*')
                ->distinct()
                ->get();
            return $menu;
        }
    }

    public static function accessRow($role, $created_by)
    {
        $user = Auth::user();
        return ($role->only_auth == 0 || $created_by == $user->id);
    }

}