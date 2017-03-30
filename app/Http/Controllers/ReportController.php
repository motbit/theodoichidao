<?php

namespace App\Http\Controllers;

use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\User;
use App\Viphuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
//        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
//            return redirect('/errpermission');
//        }

        $unit=Unit::orderBy('created_at', 'DESC')->get();
        $users = User::orderBy('fullname', 'ASC')->get();
        $sourcesteering=Sourcesteering::orderBy('created_at', 'DESC')->get();
        $viphuman = Viphuman::orderBy('created_at', 'DESC')->get();

        $firstunit = array();
        $secondunit = array();
        $tree_unit = array();
        foreach ($unit as $row) {
            if ($row->parent_id == 0){
                $children = array();
                foreach ($unit as $c) {
                    if ($c->parent_id == $row->id){
                        $children[$c->id] = $c;
                    }
                }
                $row->children = $children;
                $tree_unit[] = $row;
            }
        }
        foreach ($unit as $row) {
            $firstunit["u|" . $row->id] = $row->name;
            $secondunit["u|" . $row->id] = $row->shortname;
        }
        foreach ($users as $row){
            $firstunit["h|" . $row->id] = $row->fullname;
            $secondunit["h|" . $row->id] = $row->fullname;
        }

        $dataunit=Unit::orderBy('created_at', 'DESC')->get();
        $datauser=User::orderBy('fullname', 'ASC')->get();

        $firstunit = array();
        $secondunit = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->name;
        }

        $datauser=User::orderBy('fullname', 'ASC')->get();
        $user = array();
        foreach($datauser as $row){
            $user[$row->id] = $row->fullname;
        }


//        if ($request->isMethod('post')) {
//            $source = $request->input('source');
//            $viphuman = $request->input('viphuman');
//            $firtunit = $request->input('firtunit');
//            $secondunit = $request->input('secondunit');
//            $progress = $request->input('progress');
//            $deadlineFrom = $request->input('deadline_from');
//            $deadlineTrom = $request->input('deadline_to');
//
//            $steering = DB::table('steeringcontent')
//                ->where('source', '=', $source)
//                ->where('conductor', '=', $viphuman)
//                ->get();
//
////            $data = Steeringcontent::where('source',$source)->orderBy('created_at', 'DESC')->get();
//            $data=Steeringcontent::orderBy('created_at', 'DESC')->get();
//        }else{
//            $steering = false;
//            $data=Steeringcontent::orderBy('created_at', 'DESC')->get();
//        }
        $steering = false;
        $data=Steeringcontent::orderBy('created_at', 'DESC')->get();

        $allsteeringcode = DB::table('sourcesteering')->pluck('code');


        return view('report.index',['lst'=>$data, 'firstunit'=>$firstunit,'secondunit'=>$secondunit, 'treeunit'=>$tree_unit,
            'unit'=>$unit, 'user'=>$user, 'sourcesteering'=>$sourcesteering, 'viphuman'=>$viphuman,
            'allsteeringcode'=>$allsteeringcode->all(), 'unit'=>$firstunit,'unit2'=>$secondunit, 'users'=>$users]);
    }

}


