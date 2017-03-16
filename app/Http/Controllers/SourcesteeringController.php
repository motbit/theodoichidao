<?php

namespace App\Http\Controllers;

use App\Sourcesteering;
use Illuminate\Http\Request;

class SourcesteeringController extends Controller
{
    public function index()
    {
        return view("sourcesteering/index");

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

        $result=Sourcesteering::where('id',$request->input('id'))->delete();
    }
    #endregion

}


