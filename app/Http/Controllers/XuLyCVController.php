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
use App\Congviecdaumoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class XuLyCVController extends Controller
{
    public function daumoi(Request $request)
    {
        $user = Auth::user();
        $data = DB::table('steeringcontent')
            ->join('congviecdaumoi', 'congviecdaumoi.steering', '=', 'steeringcontent.id')
            ->where('congviecdaumoi.unit', '=', $user->unit)
            ->select('steeringcontent.*')
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

    public function duocgiao(Request $request)
    {
        $user = Auth::user();

        $danhan = DB::table('congviecdaumoi')->select('steering')->get();
        $danhan_array = array();
        foreach ($danhan as $r) {
            $danhan_array[] = $r->steering;
        }

        $data = DB::table('steeringcontent')
            ->where([
                ['unit', '=', $user->unit],
                ['xn', '=', 'C'],
            ])->whereNotIn('id', $danhan_array)
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
        return view('xulycv.duocgiao',['data'=>$data,'unit'=>$firstunit,'unit2'=>$secondunit, 'source'=>$source]);
    }

    public function nguonchidao()
    {

        $data = DB::table('sourcesteering')
            ->join('type', 'sourcesteering.type', '=', 'type.id')
            ->join('viphuman', 'sourcesteering.conductor', '=', 'viphuman.id')
            ->select('sourcesteering.*', 'type.name as typename', 'viphuman.name as conductorname')
            ->get();

        return view("xulycv/nguonchidao")->with('data', $data);

    }

    public function nhancongviec(Request $request)
    {
        $result=Congviecdaumoi::insert([
            'unit'=>$request->input('unit'),
            'steering'=>$request->input('steering'),
            'user'=>$request->input('user'),
            'status'=>$request->input('status'),
        ]);

        return redirect()->action(
            'XuLyCVController@duocgiao', ['update' => $result]
        );

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