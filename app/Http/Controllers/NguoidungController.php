<?php

namespace App\Http\Controllers;

use App\nguoidung;
use Illuminate\Http\Request;

class NguoidungController extends Controller
{
    public function index()
    {
            $data=Nguoidung::orderBy('created_at', 'DESC')->get();
            return view("nguoidung/index")->with('nguoidung',$data);

    }

    public function edit(Request $request)
    {
        $data=Nguoidung::where('id',$request->input('id'))->get();
        return view("nguoidung/update")->with('nguoidung',$data);

    }

    public function addform(Request $request)
    {
        return view("nguoidung/add");
    }

    public function add(Request $request)
    {

        $result=Nguoidung::where('id',$request->input('id'))->insert([
            'username'=>$request->input('username'),
            'fullname'=>$request->input('fullname'),
        ]);

        if($result) {
            return redirect()->action(
                'NguoidungController@index', ['add' => 1]
            );
        } else {
            return redirect()->action(
                'NguoidungController@add', ['error' => 1]
            );
        }




    }

    public function update(Request $request)
    {

        $result=Nguoidung::where('id',$request->input('id'))->update([
            'username'=>$request->input('username'),
            'fullname'=>$request->input('fullname'),
        ]);

        $data=Nguoidung::where('id',$request->input('id'))->get();

        return view("nguoidung/update")->with('nguoidung',$data)->with("result",$result);

    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result=Nguoidung::where('id',$request->input('id'))->delete();
        if($result) {
            return redirect()->action(
                'NguoidungController@index', ['delete' => $request->input('id')]
            );
        } else {
            return redirect()->action(
                'NguoidungController@index', ['delete' => "0:".$request->input('id')]
            );
        }
    }
    #endregion

}


