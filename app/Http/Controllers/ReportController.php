<?php

namespace App\Http\Controllers;

use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\User;
use App\Utils;
use App\Viphuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;

class ReportController extends Controller
{
    public function export(Request $request) {
        $chuahoanthanh_dunghan = intval( $request->input('v1') );
        $chuahoanthanh_quahan = intval( $request->input('v2') );
        $hoanthanh_dunghan = intval( $request->input('v3') );
        $hoanthanh_quahan = intval( $request->input('v4') );
        $bi_huy = intval( $request->input('v5') );
        $total = $chuahoanthanh_dunghan + $chuahoanthanh_quahan + $hoanthanh_dunghan + $hoanthanh_quahan + $bi_huy;

        $filter = $request->input('f');

        $fileName = base_path() . "/storage/example/format-baocao.xlsx";
        $footer = "*) Dữ liệu được trích suất từ hệ thống theodoichidao.moet.gov.vn" . $_ENV["ALIAS"] . " (" . date('H:i d/m/Y') .")";
        $excelobj = PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);

        $excelobj->getActiveSheet()->setCellValue('A2', "BÁO CÁO TÌNH HÌNH THỰC HIỆN NHIỆM VỤ " . $_ENV["SYSNAME"]);


        $excelobj->getActiveSheet()->setCellValue('A5', $total)
            ->setCellValue('B5', $chuahoanthanh_dunghan . " (" . round(($chuahoanthanh_dunghan/$total)*100) . "%)")
            ->setCellValue('C5', $chuahoanthanh_quahan . " (" . round(($chuahoanthanh_quahan/$total)*100) . "%)")
            ->setCellValue('D5', $hoanthanh_dunghan . " (" . round(($hoanthanh_dunghan/$total)*100) . "%)")
            ->setCellValue('E5', $hoanthanh_quahan . " (" . round(($hoanthanh_quahan/$total)*100) . "%)")
            ->setCellValue('F5', $bi_huy . " (" . round(($bi_huy/$total)*100) . "%)")
            ->setCellValue('G5', $filter)
            ->setCellValue('A6', $footer);

        $output_file = "/public/baocao/export-data-" . date("dmYHis") . ".xlsx";
        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2010");
        $objWriter->save(base_path() . $output_file);
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=baocaotonghop" . date('Ymd') . ".xlsx");
        readfile(base_path() . $output_file);
    }

    public function exportSteering(Request $request) {
        $rowsort = "id";
        $typesort = "DESC";
        if (isset($request->rowsort))
            $rowsort = $request->rowsort;
        if (isset($request->typesort))
            $typesort = $request->$typesort;
        $exportdata = Utils::getDataExport($request->data, $rowsort, $typesort);
        $fileName = base_path() . "/storage/example/template_steering.xlsx";
        $excelobj = PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);
        foreach($exportdata as $idx=>$data){
            $excelobj->getActiveSheet()->setCellValue('A'. ($idx + 2), $idx + 1)
                ->setCellValue('B'. ($idx + 2), $data['content'])
                ->setCellValue('C'. ($idx + 2), $data['source'])
                ->setCellValue('D'. ($idx + 2), $data['unit'])
                ->setCellValue('E'. ($idx + 2), $data['follow'])
                ->setCellValue('F'. ($idx + 2), $data['deadline'])
                ->setCellValue('G'. ($idx + 2), $data['status'])
                ->setCellValue('H'. ($idx + 2), $data['progress'])
                ->setCellValue('I'. ($idx + 2), $data['conductor']);
            $excelobj->getActiveSheet()->getRowDimension(($idx + 2))->setRowHeight(-1);

        }
        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $output_file = "/baocao/Danhmucnhiemvu" . date("dmyhis") . ".xlsx";
        $objWriter->save(base_path() . "/public" . $output_file);
        return response()->json(['file' => $output_file]);
    }

    public function exportSteeringBK(Request $request) {
        $rowsort = "id";
        $typesort = "DESC";
        if (isset($request->rowsort))
            $rowsort = $request->rowsort;
        $fileName = base_path() . "/storage/example/template_steering.xlsx";
        $excelobj = PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);
        foreach($request->data as $idx=>$data){
            $excelobj->getActiveSheet()->setCellValue('A'. ($idx + 2), $idx + 1)
                ->setCellValue('B'. ($idx + 2), $data['content'])
                ->setCellValue('C'. ($idx + 2), $data['source'])
                ->setCellValue('D'. ($idx + 2), $data['unit'])
                ->setCellValue('E'. ($idx + 2), $data['follow'])
                ->setCellValue('F'. ($idx + 2), $data['deadline'])
                ->setCellValue('G'. ($idx + 2), $data['status'])
                ->setCellValue('H'. ($idx + 2), $data['progress']);
            $excelobj->getActiveSheet()->getRowDimension(($idx + 2))->setRowHeight(-1);

        }
        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $output_file = "/baocao/Danhmucnhiemvu" . date("dmyhis") . ".xlsx";
        $objWriter->save(base_path() . "/public" . $output_file);
        return response()->json(['file' => $output_file]);
    }

    public function exportReport(Request $request) {
        $fileName = base_path() . "/storage/example/template_report.xlsx";
        $excelobj = PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);
        foreach($request->data as $idx=>$data){
            $excelobj->getActiveSheet()->setCellValue('A'. ($idx + 2), $idx + 1)
                ->setCellValue('B'. ($idx + 2), $data['content'])
                ->setCellValue('C'. ($idx + 2), $data['conductor'])
                ->setCellValue('D'. ($idx + 2), $data['time'])
                ->setCellValue('E'. ($idx + 2), $data['source'])
                ->setCellValue('F'. ($idx + 2), $data['unit'])
                ->setCellValue('G'. ($idx + 2), $data['follow'])
                ->setCellValue('H'. ($idx + 2), $data['deadline'])
                ->setCellValue('I'. ($idx + 2), $data['status']);
        }
        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $output_file = "/baocao/Danhmucbaocao" . date("dmyhis") . ".xlsx";
        $objWriter->save(base_path() . "/public" . $output_file);
        return response()->json(['file' => $output_file]);
    }

    public function exportUnit(Request $request) {
        $fileName = base_path() . "/storage/example/format-baocaodonvi.xlsx";
        $excelobj = PHPExcel_IOFactory::load($fileName);
        $excelobj->setActiveSheetIndex(0);
        $excelobj->getActiveSheet()->toArray(null, true, true, true);

        $filter = $request->input('filter');
        $count = 5;
        $total = 0;
        $total_v1 = 0;
        $total_v2 = 0;
        $total_v3 = 0;
        $total_v4 = 0;
        $total_v5 = 0;

        $excelobj->getActiveSheet()->setCellValue('A2', "BÁO CÁO TÌNH HÌNH THỰC HIỆN NHIỆM VỤ " . $_ENV["SYSNAME"]);

        foreach($request->data as $idx=>$data){

            $total += $data['total'];
            $total_v1 += $data['v1'];
            $total_v2 += $data['v2'];
            $total_v3 += $data['v3'];
            $total_v4 += $data['v4'];
            $total_v5 += $data['v5'];

            $excelobj->getActiveSheet()->setCellValue('A'. ($idx + 5), $idx + 1)
                ->setCellValue('B'. ($idx + 5), $data['unit'])
                ->setCellValue('C'. ($idx + 5), $data['total'])
                ->setCellValue('D'. ($idx + 5), $data['v1'] . " (" . round(($data['v1']/$data['total'])*100) . "%)")
                ->setCellValue('E'. ($idx + 5), $data['v2'] . " (" . round(($data['v2']/$data['total'])*100) . "%)")
                ->setCellValue('F'. ($idx + 5), $data['v3'] . " (" . round(($data['v3']/$data['total'])*100) . "%)")
                ->setCellValue('G'. ($idx + 5), $data['v4'] . " (" . round(($data['v4']/$data['total'])*100) . "%)")
                ->setCellValue('H'. ($idx + 5), $data['v5'] . " (" . round(($data['v5']/$data['total'])*100) . "%)");

            $excelobj->getActiveSheet()
                ->getStyle('A'.($idx + 5).':I'.($idx + 5))
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
                ->getColor()
                ->setRGB('000000');

            $count ++;
        }

/*        $excelobj->getActiveSheet()
            ->setCellValue('B'. ($idx + 6), $_ENV["DEPTNAME"])
            ->setCellValue('C'. ($idx + 6),  $total)
            ->setCellValue('D'. ($idx + 6),  $total_v1)
            ->setCellValue('E'. ($idx + 6),  $total_v2)
            ->setCellValue('F'. ($idx + 6),  $total_v3)
            ->setCellValue('G'. ($idx + 6),  $total_v4)
            ->setCellValue('H'. ($idx + 6),  $total_v5);*/

/*        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FF0000')
            ));
        $excelobj->getActiveSheet()->getStyle('A'.($idx + 6).':H'.($idx + 6))->applyFromArray($styleArray);*/

/*        $excelobj->getActiveSheet()
            ->getStyle('A'.($idx + 6).':I'.($idx + 6))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
            ->getColor()
            ->setRGB('000000');*/

        $excelobj->getActiveSheet()->mergeCells('I5:I'.($count-1));


        $excelobj->getActiveSheet()->setCellValue('I5', $filter);
        $footer = "*) Dữ liệu được trích suất từ hệ thống theodoichidao.moet.gov.vn" . $_ENV["ALIAS"] . " (" . date('H:i d/m/Y') .")";
        $excelobj->getActiveSheet()->setCellValue('A' . ($count + 1), $footer);
        $objWriter = PHPExcel_IOFactory::createWriter($excelobj, "Excel2007");
        $output_file = "/baocao/Baocaodonvi" . date("dmyhis") . ".xlsx";
        $objWriter->save(base_path() . "/public" . $output_file);
        return response()->json(['file' => $output_file]);
    }

    public function index(Request $request)
    {

        $unit=Unit::orderBy('created_at', 'DESC')->get();
        $users = User::orderBy('fullname', 'ASC')->get();
        $sourcesteering=Sourcesteering::orderBy('id', 'DESC')->get();
        $viphuman = Viphuman::orderBy('created_at', 'DESC')->get();

        $conductor = array();
        foreach ($viphuman as $row){
            $conductor[$row->id] = $row->name;
        }

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

        $dataunit=Unit::orderBy('created_at', 'DESC')->get();

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

        $data=Steeringcontent::orderBy('created_at', 'DESC')->get();

        $allsteeringcode = DB::table('sourcesteering')->pluck('code');

        $dictunit = array();
        foreach ($unit as $row) {
            $dictunit[$row->id] = $row->name;
        }


        return view('report.index',['lst'=>$data, 'dictunit'=>$dictunit, 'treeunit'=>$tree_unit,
            'unit'=>$unit, 'user'=>$user, 'users'=>$users, 'sourcesteering'=>$sourcesteering, 'viphuman'=>$viphuman,
            'allsteeringcode'=>$allsteeringcode->all(), 'unit'=>$firstunit,'unit2'=>$secondunit, 'users'=>$users, 'conductor' => $conductor]);
    }

    public function unit(Request $request)
    {
        $unit=Unit::orderBy('created_at', 'DESC')->get();
        $unitall=DB::table('unit')->where('parent_id', '!=', '0')->get();
        $users = User::orderBy('fullname', 'ASC')->get();
        $sourcesteering=Sourcesteering::orderBy('id', 'DESC')->get();
        $viphuman = Viphuman::orderBy('created_at', 'DESC')->get();

        $conductor = array();
        foreach ($viphuman as $row){
            $conductor[$row->id] = $row->name;
        }

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

        $dataunit=Unit::orderBy('created_at', 'DESC')->get();

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

        $data=Steeringcontent::orderBy('unit', 'DESC')->get();

        $allsteeringcode = DB::table('sourcesteering')->pluck('code');

        $dictunit = array();
        foreach ($unit as $row) {
            $dictunit[$row->id] = $row->name;
        }

        return view('report.unit',['lst'=>$data, 'dictunit'=>$dictunit, 'treeunit'=>$tree_unit,
            'unitall'=>$unitall, 'user'=>$user,'users'=>$users, 'sourcesteering'=>$sourcesteering, 'viphuman'=>$viphuman,
            'allsteeringcode'=>$allsteeringcode->all(), 'unit'=>$firstunit,'unit2'=>$secondunit, 'users'=>$users, 'conductor' => $conductor]);
    }

}


