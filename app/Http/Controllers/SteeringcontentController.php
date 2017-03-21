<?php

namespace App\Http\Controllers;

use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SteeringcontentController extends Controller
{
    public function index(Request $request)
    {

        $source = intval( $request->input('source') );

        if($source) {
            $steering = DB::table('sourcesteering')
                ->where('id', '=', $source)
                ->get()->first();
            $data=Steeringcontent::where('source',$source)->orderBy('created_at', 'DESC')->get();
        } else {
            $steering = false;
            $data=Steeringcontent::orderBy('created_at', 'DESC')->get();
        }



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
        return view('steeringcontent.index',['lst'=>$data,'unit'=>$firstunit,'unit2'=>$secondunit,'source'=>$source,'steering'=>$steering]);
    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );

        $unit=Unit::orderBy('created_at', 'DESC')->get();
        $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();

        foreach ($unit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->shortname;
        }

        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "[" . $row->code . "] " . $row->name;
        }

        if($id > 0) {
            $data=Steeringcontent::where('id',$id)->get();

            $dtfollow = explode(",",$data[0]['follow']);
            return view('steeringcontent.update',['firstunit'=>$firstunit,'secondunit'=>$secondunit,'source'=>$source,'data'=>$data,'dtfollow'=>$dtfollow, 'sourcesteering'=>$sourcesteering]);
        } else {
            return view('steeringcontent.add',['firstunit'=>$firstunit,'secondunit'=>$secondunit,'source'=>$source, 'sourcesteering'=>$sourcesteering]);
        }
    }

    public function update(Request $request)
    {

        $id = intval( $request->input('id') );
        if($id > 0) {
            $result=Steeringcontent::where('id',$request->input('id'))->update([
                'content'=>$request->input('content'),
                'source'=>$request->input('source'),
                'unit'=>$request->input('firtunit'),
                'follow'=> !empty($request->input('secondunit')) ? implode(",",$request->input('secondunit')) : "",
                'note'=>$request->input('note'),
                'deadline'=>$request->input('deadline'),
                'xn'=>$request->input('confirm'),
                'status'=>$request->input('status'),
            ]);

            $data=Steeringcontent::where('id',$request->input('id'))->get();

            return redirect()->action(
                'SteeringcontentController@index', ['update' => $result]
            );

        } else {

            $result=Steeringcontent::insert([
                'content'=>$request->input('content'),
                'source'=>$request->input('source'),
                'unit'=>$request->input('firtunit'),
                'follow'=> !empty($request->input('secondunit')) ? implode(",",$request->input('secondunit')) : "",
                'deadline'=>$request->input('deadline'),
            ]);

            if($result) {
                return redirect()->action(
                    'SteeringcontentController@index', ['add' => 1]
                );
            } else {
                return redirect()->action(
                    'SteeringcontentController@index', ['error' => 1]
                );
            }
        }

    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result=Steeringcontent::where('id',$request->input('id'))->delete();
        if($result) {
            return redirect()->action(
                'SteeringcontentController@index', ['delete' => $request->input('id')]
            );
        } else {
            return redirect()->action(
                'SteeringcontentController@index', ['delete' => "0:".$request->input('id')]
            );
        }
    }
    #endregion

}


