<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::orderBy('created_at', 'DESC')->get();

        $treeUnit = array();
        foreach ($unit as $row) {
            if ($row->parent_id == 0){
                $children = array();
                foreach ($unit as $c) {
                    if ($c->parent_id == $row->id){
                        $children[$c->id] = $c;
                    }
                }
                $row->children = $children;
                $treeUnit[] = $row;
            }
        }

        return view('unit.index',['lstunit' => $unit, 'treeunit'=>$treeUnit]);

    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );
        $unit = Unit::orderBy('created_at', 'DESC')->get();

        if($id > 0) {
            $data=Unit::where('id',$id)->get();
//            return view("unit/update")->with('unit', $unit, 'data' => $data);
            return view('unit.update',['unit' => $unit, 'data' => $data]);
        } else {
            return view('unit.add',['unit' => $unit]);
        }
    }

    public function update(Request $request)
    {

        $id = intval( $request->input('id') );
        if($id > 0) {
            $result=Unit::where('id',$request->input('id'))->update([
                'name'=>$request->input('name'),
                'description'=>$request->input('description'),
                'shortname'=>$request->input('shortname'),
                'parent_id' => $request->input('parent_id'),
            ]);

            $data = Unit::where('id',$request->input('id'))->get();

            return redirect()->action(
                'UnitController@index', ['update' => $result]
            );

        } else {

            $result = Unit::insert([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'shortname' => $request->input('shortname'),
                'parent_id' => $request->input('parent_id'),
            ]);

            if($result) {
                return redirect()->action(
                    'UnitController@index', ['add' => 1]
                );
            } else {
                return redirect()->action(
                    'UnitController@update', ['error' => 1]
                );
            }
        }

    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result=Unit::where('id',$request->input('id'))->delete();
        if($result) {
            return redirect()->action(
                'UnitController@index', ['delete' => $request->input('id')]
            );
        } else {
            return redirect()->action(
                'UnitController@index', ['delete' => "0:".$request->input('id')]
            );
        }
    }
    #endregion

}


