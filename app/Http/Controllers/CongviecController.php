<?php

namespace App\Http\Controllers;

use App\steeringcontent;
use App\unit;
use App\user;
use App\sourcesteering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CongviecController extends Controller
{
    public function daumoi()
    {
        $user = Auth::user();

        $data=Steeringcontent::where('unit', $user->unit)->get();

        $dataunit=Unit::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->shortname;
        }

        $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();
        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = "" . $row->code . "";
        }

        return view('congviec.daumoi',['lst'=>$data,'unit'=>$firstunit,'unit2'=>$secondunit,'source'=>$source]);
    }
}


