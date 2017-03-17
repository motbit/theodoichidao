<?php

namespace App\Http\Controllers;

use App\Chucnang;
use Illuminate\Http\Request;

class ChucnangController extends Controller
{
    public function index()
    {
        return view("chucnang/index");

    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
        } else {
        }
    }

    public function update(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
        } else {
        }
    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result=Chucnang::where('id',$request->input('id'))->delete();
    }
    #endregion

}


