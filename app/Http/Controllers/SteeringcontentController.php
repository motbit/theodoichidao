<?php

namespace App\Http\Controllers;

use App\steeringcontent;
use App\unit;
use App\sourcesteering;
use Illuminate\Http\Request;

class SteeringcontentController extends Controller
{
    public function index()
    {
        $data=Steeringcontent::orderBy('created_at', 'DESC')->get();

        $dataunit=Unit::orderBy('created_at', 'DESC')->get();
        $unit = array();
        foreach ($dataunit as $row) {
            $unit[$row->id] = $row->name;
        }

        $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }
        return view('steeringcontent.index',['lst'=>$data,'unit'=>$unit,'source'=>$source]);
    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
            $data=Steeringcontent::where('id',$id)->get();
            return view("steeringcontent/update")->with('steeringcontent',$data);
        } else {


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

            $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();
            return view('steeringcontent.add',['firstunit'=>$firstunit,'secondunit'=>$secondunit,'source'=>$source]);
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
                'follow'=>$request->input('secondunit'),
                'deadline'=>$request->input('deadline'),
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
                'follow'=>implode(",",$request->input('secondunit')),
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


