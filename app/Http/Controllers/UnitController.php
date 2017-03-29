<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Validator;

class UnitController extends Controller
{
    public function index()
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
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
        $messages = [
            'name.required' => 'Yêu cầu nhập tên Ban - đơn vị',
            'shortname.required' => 'Yêu cầu nhập tên viết tắt Ban - đơn vị',
            'name.unique' => 'Tên Ban - đơn vị đã tồn tại',
            'shortname.unique' => 'Tên viết tắt Ban - đơn vị đã tồn tại.',
        ];
        if($id > 0) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:unit,name,' . $id,
                'shortname' => 'required|unique:unit,shortname,' . $id,
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('UnitController@update',["id"=>$id])
                    ->withErrors($validator)
                    ->withInput();
            }

        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:unit',
                'shortname' => 'required|unique:unit'
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('UnitController@update')
                    ->withErrors($validator)
                    ->withInput();
            }

        }

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


