<?php

namespace App\Http\Controllers;

use App\Viphuman;
use Illuminate\Http\Request;

class ViphumanController extends Controller
{
    public function index()
    {
        return view("viphuman/index");

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

        $result=ViphumanController::where('id',$request->input('id'))->delete();
    }
    #endregion

}


