<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
        $data=Unit::orderBy('created_at', 'DESC')->get();
        return view("unit/index")->with('lstunit',$data);

    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
            $data=Unit::where('id',$id)->get();
            return view("unit/update")->with('unit',$data);
        } else {
            return view("unit/add");
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
                'order'=>$request->input('order'),
            ]);

            $data=Unit::where('id',$request->input('id'))->get();

            return redirect()->action(
                'UnitController@index', ['update' => $result]
            );

        } else {

            $result=Unit::insert([
                'name'=>$request->input('name'),
                'description'=>$request->input('description'),
                'shortname'=>$request->input('shortname'),
                'order'=>$request->input('order'),
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


