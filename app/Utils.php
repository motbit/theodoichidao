<?php
/**
 * Created by PhpStorm.
 * User: Windows 10 Gamer
 * Date: 01/04/2017
 * Time: 9:01 SA
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utils extends Model
{
    public static function listTypeSource()
    {
        return DB::table('type')->orderBy('_order', 'ASC')->get();
    }

    public static function listConductor()
    {
        return DB::table('viphuman')->orderBy('id', 'ASC')->get();
    }

    public static function getDataExport($data, $rowsort, $typesort)
    {
        $steering = DB::table('steeringcontent')->whereIn('id', $data)
            ->orderBy($rowsort, $typesort)
            ->get();

        //Lay danh sach don vi
        $dataunit = DB::table('unit')->where('parent_id', '>', 0)->get();
        $unit = array();
        foreach ($dataunit as $row) {
            $unit[$row->id] = $row->name;
        }
        //Lay danh sach nguoi dung
        $datauser = DB::table('user')->get();
        $user = array();
        foreach ($datauser as $row) {
            $user[$row->id] = $row->fullname;
        }

        $exportData = array();

        foreach ($steering as $row) {
            $temp = array();
            $temp['content'] = $row->content;
            $temp['source'] = trim(str_replace('|', PHP_EOL, $row->source));

            $strunit = "";
            foreach ($units = explode(',', $row->unit) as $i) {
                $spl = explode('|', $i);
                $validate = ($i != "");
                $val = "";
                if ($spl[0] == 'u' && isset($unit[$spl[1]])) {
                    $validate = true;
                    $val = $unit[$spl[1]];
                } else if ($spl[0] == 'h' && isset($user[$spl[1]])) {
                    $validate = true;
                    $val = $user[$spl[1]];
                } else {
                    $val = $i;
                }
                if ($validate) {
                    $strunit = $strunit . $val . PHP_EOL;
                }
            }
            $temp['unit'] = $strunit;

            $strfollow = "";
            foreach ($follows = explode(',', $row->follow) as $i) {
                $spl = explode('|', $i);
                $validate = ($i != "");
                $val = "";
                if ($spl[0] == 'u' && isset($unit[$spl[1]])) {
                    $validate = true;
                    $val = $unit[$spl[1]];
                } else if ($spl[0] == 'h' && isset($user[$spl[1]])) {
                    $validate = true;
                    $val = $user[$spl[1]];
                } else {
                    $val = $i;
                }
                if ($validate) {
                    $strfollow = $strfollow . $val . PHP_EOL;
                }
            }
            $temp['follow'] = $strfollow;
            $temp['deadline'] = "";
            if ($row->deadline != "") {
                $temp['deadline'] = date("d/m/Y", strtotime($row->deadline));
            }

            //Lay trang thai
            $st = 1;
            if ($row->status == 1) {
                if ($row->deadline == "" || $row->complete_time < $row->deadline) {
                    $st = 2;
                } else {
                    $st = 3;
                }
            } else if ($row->status == -1) {
                $st = 6;
            } else if ($row->deadline == "") {
                $st = 1;
            } else {
                if (date('Y-m-d') > $row->deadline) {
                    $st = 4;
                } else if (date('Y-m-d', strtotime("+7 day")) > $row->deadline) {
                    $st = 5;
                } else {
                    $st = 1;
                }
            }
            $name_stt = array();
            $name_stt[1] = "Đang thực hiện (trong hạn)";
            $name_stt[2] = "Đã hoàn thành (đúng hạn)";
            $name_stt[3] = "Đã hoàn thành (quá hạn)";
            $name_stt[4] = "Đang thực hiện (quá hạn)";
            $name_stt[5] = "Sắp hết hạn (7 ngày)";
            $name_stt[6] = "Bị hủy";

            $temp['status'] = $name_stt[$st];
//            $temp['progress'] = $row->progress;
            $dataprogress = DB::table('progress_log')->where('steeringcontent', '=', $row->id)->get();
            $progress = "";
            foreach ($dataprogress as $p){
                $progress .= '- ' . $p->note . PHP_EOL;
            }
            $temp['progress'] = $progress;
            $temp['conductor'] = $row->conductor;

            $exportData[] = $temp;
        }
        return $exportData;
    }

    public static function stripUnicode($str){
        if(!$str) return false;
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
        $str = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $str);
        return $str;
    }

    public static function dateformat($date) {

        if(preg_match("/^[0-9]{2}-[0-9]{2}-[0-9]{2}$/",$date)) {
            $date = \DateTime::createFromFormat('d-m-y', $date);
            return $date;
        } else if(preg_match("/^[0-9]{2}-[0-9]{2}-[0-9]{4}$/",$date)) {
            $date = \DateTime::createFromFormat('d-m-Y', $date);
            return $date;
        } else if(preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{2}$/",$date)) {
            $date = \DateTime::createFromFormat('d/m/y', $date);
            return $date;
        } else if(preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/",$date)) {
            $date = \DateTime::createFromFormat('d/m/Y', $date);
            return $date;
        } else if(preg_match("/^[0-9]{2}\/[0-9]{1}\/[0-9]{4}$/",$date)) {
            $date = \DateTime::createFromFormat('d/n/Y', $date);
            return $date;
        }else if(preg_match("/^[0-9]{2}\/[0-9]{1}\/[0-9]{2}$/",$date)) {
            $date = \DateTime::createFromFormat('d/n/y', $date);
            return $date;
        }else if(preg_match("/^[0-9]{2}-[0-9]{1}-[0-9]{2}$/",$date)) {
            $date = \DateTime::createFromFormat('d-n-y', $date);
            return $date;
        } else if(preg_match("/^[0-9]{2}-[0-9]{1}-[0-9]{4}$/",$date)) {
            $date = \DateTime::createFromFormat('d-n-Y', $date);
            return $date;
        }else {
            return null;
        }
    }

}