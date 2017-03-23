<?php

namespace App\Http\Controllers;

use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\Viphuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SteeringcontentController extends Controller
{
    public function index(Request $request)
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
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
            $secondunit[$row->id] = $row->name;
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
        $priority = $type = DB::table('priority')->get();
        $viphuman = Viphuman::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();
        $tree_unit = array();
        foreach ($unit as $row) {
            if ($row->parent_id == 0){
                $children = array();
                foreach ($unit as $c) {
                    if ($c->parent_id == $row->id){
                        $children[$c->id] = $c;
                    }
                }
                $row->children = $children;
                $tree_unit[] = $row;
            }
        }

//        dd($tree_unit);

        foreach ($unit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->shortname;
        }

        $source = array();
        foreach ($sourcesteering as $row) {
//            $source[$row->id] = "[" . $row->code . "] " . $row->name;
            $source[$row->id] = $row->code;
        }

        if($id > 0) {
            $data=Steeringcontent::where('id',$id)->get();

            $dtfollowArr = explode(",",$data[0]['follow']);
            $dtfollow = $data[0]['follow'];

            return view('steeringcontent.update',['firstunit'=>$firstunit,'secondunit'=>$secondunit,'source'=>$source,
                'data'=>$data,'dtfollow'=>$dtfollow, 'dtfollowArr'=>$dtfollowArr, 'sourcesteering'=>$sourcesteering, 'treeunit'=>$tree_unit,'unit'=>$unit,
                'priority'=>$priority, 'viphuman'=>$viphuman]);
        } else {

            return view('steeringcontent.add',['sourcesteering'=>$sourcesteering,
                'treeunit'=>$tree_unit,'unit'=>$unit, 'priority'=>$priority, 'viphuman'=>$viphuman]);
        }
    }

    public function update(Request $request)
    {

        $id = intval( $request->input('id') );
        if($id > 0) {
            $secondunitArr = $request->input('secondunit');
            $secondunit = implode(",", $secondunitArr);

            $result=Steeringcontent::where('id',$request->input('id'))->update([
                'content'=>$request->input('content'),
                'source'=>$request->input('source'),
                'unit'=>$request->input('firtunit'),
//                'follow'=> !empty($request->input('secondunit')) ? implode(",",$request->input('secondunit')) : "",
                'follow'=>$secondunit,
//                'note'=>$request->input('note'),
//                'deadline'=>$request->input('deadline'),
//                'xn'=>$request->input('confirm'),
//                'status'=>$request->input('status'),
                'steer_time' => date("Y-m-d", strtotime($request->input('steer_time')) ),
                'deadline'=> date("Y-m-d", strtotime($request->input('deathline')) ),
                'conductor' => $request->input('viphuman')
            ]);

            $data=Steeringcontent::where('id',$request->input('id'))->get();

            return redirect()->action(
                'SteeringcontentController@index', ['update' => $result]
            );

        } else {
            $secondunitArr = $request->input('secondunit');
            $secondunit = implode(",", $secondunitArr);

            $result=Steeringcontent::insert([
                'content'=>$request->input('content'),
                'source'=>$request->input('source'),
                'unit'=>$request->input('firtunit'),
                'follow'=>$secondunit,
                'priority'=>$request->input('priority'),
                'conductor' => $request->input('viphuman'),
                'steer_time' => date("Y-m-d", strtotime($request->input('steer_time')) ),
                'deadline'=> date("Y-m-d", strtotime($request->input('deathline')) )
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


