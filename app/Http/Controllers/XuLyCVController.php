<?php
/**
 * Created by PhpStorm.
 * User: Windows 10 Gamer
 * Date: 16/03/2017
 * Time: 7:17 CH
 */

namespace App\Http\Controllers;

use App\Sourcesteering;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class XuLyCVController extends Controller
{
    public function daumoi(Request $request)
    {
        $user = Auth::user();
        $data = DB::table('steeringcontent')
            ->where('unit', '=', $user->unit)
            ->get();
        $dataunit=Unit::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->shortname;
        }

        $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }
        return view('xulycv.daumoi',['data'=>$data,'unit'=>$firstunit,'unit2'=>$secondunit, 'source'=>$source]);
    }

    public function phoihop(Request $request)
    {
        $user = Auth::user();
        $data = DB::table('steeringcontent')
            ->where('follow', 'like', '%,'.$user->unit)
            ->orwhere('follow', 'like', '%,'.$user->unit.',%')
            ->orwhere('follow', 'like', $user->unit.',%')
            ->get();
        $dataunit=Unit::orderBy('created_at', 'DESC')->get();
        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->shortname;
        }

        $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }
        return view('xulycv.phoihop',['data'=>$data,'unit'=>$firstunit,'unit2'=>$secondunit, 'source'=>$source]);
    }
}