<?php

namespace App\Http\Controllers;

use App\Steeringcontent;
use Illuminate\Http\Request;

class SteeringcontentController extends Controller
{
    public function index()
    {
        return view("steeringcontent/index");

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

        $result=Steeringcontent::where('id',$request->input('id'))->delete();
    }
    #endregion

}


