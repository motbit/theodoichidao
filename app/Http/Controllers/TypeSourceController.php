<?php
/**
 * Created by PhpStorm.
 * User: Windows 10 Gamer
 * Date: 04/04/2017
 * Time: 5:02 CH
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeSourceController extends Controller
{
    public function index()
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
        $type = DB::table('type')->orderBy('_order', 'ASC')->get();
        return view('type.index', ['type'=>$type]);
    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
            $type = DB::table('type')->where('id', '=', $id)->get();
            return view("type.update", ['type'=>$type, 'id'=>$id]);
        } else {
            return view("type.update", ['id'=>$id]);
        }
    }

    public function update(Request $request)
    {
        $id = intval( $request->input('id') );
        $name = $request->input('name');
        echo $name;
        if($id > 0) {
            DB::table('type')->where('id', '=', $id)->update(['name'=>$name]);
            return redirect()->action('TypeSourceController@index');
        } else {
            DB::table('type')->insert(['name'=>$name]);
            return redirect()->action('TypeSourceController@index');
        }
    }

    public function delete(Request $request)
    {
        $id = intval( $request->input('id') );
        DB::table('type')->where('id', '=', $id)->delete();
        return redirect()->action('TypeSourceController@index');
    }
}