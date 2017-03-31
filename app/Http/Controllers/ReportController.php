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
use PHPExcel;
use PHPExcel_IOFactory;

class ReportController extends Controller
{
    public function export(Request $request) {


        $chuahoanthanh_dunghan = intval( $request->input('v1') );
        $chuahoanthanh_quahan = intval( $request->input('v2') );
        $hoanthanh_dunghan = intval( $request->input('v3') );
        $hoanthanh_quahan = intval( $request->input('v4') );
        $bi_huy = intval( $request->input('v5') );
        $total = $chuahoanthanh_dunghan + $chuahoanthanh_quahan + $hoanthanh_dunghan + $hoanthanh_quahan + $bi_huy;

        $fileName = base_path() . "/storage/example/format-baocao.xlsx";

        $excelobj = PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);
        $excelobj->getActiveSheet()->setCellValue('A4', $total)
            ->setCellValue('B4', $chuahoanthanh_dunghan)
            ->setCellValue('C4', $chuahoanthanh_quahan)
            ->setCellValue('D4', $hoanthanh_dunghan)
            ->setCellValue('E4', $hoanthanh_quahan)
            ->setCellValue('F4', $bi_huy);

        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $objWriter->save(base_path() . "/storage/example/export-data-" . date("dmyhis") . ".xlsx");
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=baocaonhiemvu.xlsx");
        readfile(base_path() . "/storage/example/export-data-" . date("dmyhis") . ".xlsx");
    }
    public function index(Request $request)
    {
//        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
//            return redirect('/errpermission');
//        }

        $unit=Unit::orderBy('created_at', 'DESC')->get();
        $users = User::orderBy('fullname', 'ASC')->get();
        $sourcesteering=Sourcesteering::orderBy('id', 'DESC')->get();
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


