<?php

namespace App\Http\Controllers;

use App\group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view("group/index");

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

        $result=Group::where('id',$request->input('id'))->delete();
    }
    #endregion

}


