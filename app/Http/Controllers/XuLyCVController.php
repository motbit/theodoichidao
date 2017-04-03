<?php
/**
 * Created by PhpStorm.
 * User: Windows 10 Gamer
 * Date: 16/03/2017
 * Time: 7:17 CH
 */

namespace App\Http\Controllers;


use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\Congviecdaumoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class XuLyCVController extends Controller
{
    public function daumoi(Request $request)
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
        $user = Auth::user();
        $data = DB::table('steeringcontent')
            ->orwhere('unit', 'like', '%u|' . $user->unit . ',%')
            ->orwhere('unit', 'like', '%h|' . $user->id . ',%')
            ->select('steeringcontent.*')
            ->get();
        $dataunit = Unit::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->name;
        }

        $sourcesteering = Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }
        return view('xulycv.daumoi', ['data' => $data, 'unit' => $firstunit, 'unit2' => $secondunit, 'source' => $source]);
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
                ['status', '=', '0'],
            ])->whereNotIn('id', $danhan_array)
            ->get();
        $dataunit = Unit::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->name;
        }

        $sourcesteering = Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }
        return view('xulycv.duocgiao', ['data' => $data, 'unit' => $firstunit, 'unit2' => $secondunit, 'source' => $source]);
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

        $result1=Congviecdaumoi::insert([
            'unit'=>$request->input('unit'),
            'steering'=>$request->input('steering'),
            'user'=>$request->input('user'),
            'status'=>$request->input('status'),
        ]);

        if($request->input('status') == 1 )
            $data = ['xn'=>'X'];
        else
            $data = ['xn'=>'K'];

        $result2=Steeringcontent::where('id',$request->input('steering'))->update($data);



        return redirect()->action(
            'XuLyCVController@duocgiao', ['update' => $result1 . ":" . $result2]
        );

    }

    public function phoihop(Request $request)
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
        $user = Auth::user();
        $data = DB::table('steeringcontent')
            ->orwhere('follow', 'like', '%u|' . $user->unit . ',%')
            ->orwhere('follow', 'like', '%h|' . $user->id . ',%')
            ->get();
        $dataunit = Unit::orderBy('created_at', 'DESC')->get();
        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->shortname;
        }

        $sourcesteering = Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }
        return view('xulycv.phoihop', ['data' => $data, 'unit' => $firstunit, 'unit2' => $secondunit, 'source' => $source]);
    }

    public function updatecv(Request $request)
    {
        $id = intval($request->input('id'));
        $note = $request->input('note');
        if (isset($note)) {
            $result=Steeringcontent::where('id',$request->input('id'))->update([
                'note'=>$request->input('note'),
                'status'=>$request->input('status')
            ]);
            return redirect()->action(
                'XuLyCVController@daumoi', ['update' => $result]
            );
        } else {
            $data = Steeringcontent::where('id', $id)->get();
            return view('xulycv.updatecv', ['data' => $data]);
        }
    }

    public function tranfer(Request $request){
        $users = array();
        $select_user = DB::table('user')->get();
        foreach ($select_user as $row){
            $users[$row->id] = $row->fullname . " (" . $row->username .")";
        }
        $steering = array();
        $select_steering = DB::table('steeringcontent')->get();
        foreach ($select_steering as $row){
            $steering[$row->id] = $row->content;
        }
        $send = DB::table('tranfer_log')
            ->join('steeringcontent', 'steeringcontent.id', '=', 'tranfer_log.steering')
            ->where('tranfer_log.sender', '=', Auth::id())
            ->orderBy('tranfer_log.id', 'desc')
            ->select('tranfer_log.*', 'steeringcontent.content as steering_name')
            ->get();
        $receive =  DB::table('tranfer_log')
            ->join('steeringcontent', 'steeringcontent.id', '=', 'tranfer_log.steering')
            ->where('tranfer_log.receiver', '=', Auth::id())
            ->orderBy('tranfer_log.id', 'desc')
            ->select('tranfer_log.*', 'steeringcontent.content as steering_name')
            ->get();
        return view('xulycv.tranfer', ['user' => $users, 'steering' => $steering,
            'send' => $send, 'receive' => $receive]);
    }
}