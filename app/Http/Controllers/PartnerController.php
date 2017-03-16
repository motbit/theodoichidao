<?php

namespace App\Http\Controllers;

use App\partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        return view("partner/index");

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

        $result=PartnerController::where('id',$request->input('id'))->delete();
    }
    #endregion

}


