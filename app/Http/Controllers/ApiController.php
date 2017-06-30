<?php

namespace App\Http\Controllers;

use App\Constant;
use App\MLogs;
use App\Progress;
use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\Viphuman;
use App\User;
use App\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class ApiController extends Controller
{

    //progress
    public function getProgress(Request $request)
    {
        $steering_id = intval($request->s);
        $progress = DB::table('progress_log')
            ->join('user', 'user.id', '=', 'progress_log.created_by')
            ->where('steeringcontent', '=', $steering_id)
            ->select('progress_log.*', 'user.fullname as created')
            ->orderBy('progress_log.id', 'desc')
            ->get();
        return response()->json($progress);
    }

    public function updateProgress(Request $request)
    {
        $steering_id = $request->steering_id;
        $note = $request->note;
        $status = intval($request->status);
        Utils::dateformat($request->time_log);
        $time_log = Utils::dateformat($request->time_log);
        $data = array();
        $data['created_by'] = Auth::user()->id;
        $data['steeringcontent'] = $steering_id;
        $data['note'] = $note;
        $data['time_log'] = $time_log;
        if ($status != -2) {
            $data['status'] = $status;
        }
        $content = array();
        $content['progress'] = $note;
        if ($status != -2) {
            $content['status'] = $status;
        }
        if ($status != 0) {
            $content['complete_time'] = $time_log;
        }
        try {
            $result1 = Progress::insertGetId($data);
            $result2 = Steeringcontent::where('id', $steering_id)->update($content);
            MLogs::write(Constant::$ACTION_CREATE, 'progress_log', $result1, '');
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        return response()->json($content);
    }


    public function getSteering(Request $request)
    {
        // Lay ra id
        $id = intval($request->input('id'));

        $unit = Unit::orderBy('created_at', 'DESC')->get();
        $sourcesteering = Sourcesteering::orderBy('created_at', 'DESC')->get();
        $user = User::orderBy('unit', 'ASC')->get();

        $tree_unit = array();
        foreach ($unit as $row) {
            if ($row->parent_id == 0) {
                $children = array();
                foreach ($unit as $c) {
                    if ($c->parent_id == $row->id) {
                        $children[$c->id] = $c;
                    }
                }
                $row->children = $children;
                $tree_unit[] = $row;
            }
        }

        $dictunit = array();
        foreach ($unit as $row) {
            $dictunit[$row->id] = $row->name;
        }


        $dictuser = array();
        foreach ($user as $row) {
            $dictuser[$row->id] = $row->fullname;
        }

        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = $row->code;
        }
        $type = DB::table('type')->orderBy('_order', 'ASC')->get();

        $data = Steeringcontent::where('id', $id)->get()->first();

        $dtfollowArr = explode(",", $data[0]['follow']);
        $dtUnitArr = explode(",", $data[0]['unit']);

        //get list source id
        $steeringSources = DB::table('steering_source')->select('source', 'note')->where('steering', $id)->get();
        $steeringSourceIds = array();
        $steeringSourceNotes = array();
        foreach ($steeringSources as $key => $sc) {
            $steeringSourceIds[$key] = $sc->source;
            $steeringSourceNotes[$sc->source] = $sc->note;
        }


        // Unit

        $n = 0;
        $firstunit = [];
        foreach ($units = explode(',', $data->unit) as $k => $i) {
            $spl = explode('|', $i);
            $validate = ($i != "");
            $val = [
                "id" => isset($spl[1]) ? $spl[1] : 0,
            ];
            if ($spl[0] == 'u' && isset($dictunit[$spl[1]])) {
                $val["type"] = "u";
                $val["name"] = $dictunit[$spl[1]];
                $n++;
            } else if ($spl[0] == 'h' && isset($dictuser[$spl[1]])) {
                $val["type"] = "h";
                $val["name"] = $dictuser[$spl[1]];
                $n++;
            } else {
                $val["type"] = "-";
                $val = $i;
            }

            if ($validate) {
                $firstunit[$k] = $val;
            }
        }

        $n = 0;
        $secondunit = [];
        foreach ($units = explode(',', $data->follow) as $k => $i) {

            $spl = explode('|', $i);
            $validate = ($i != "");
            $val = [
                "id" => isset($spl[1]) ? $spl[1] : 0,
            ];
            if ($spl[0] == 'u' && isset($dictunit[$spl[1]])) {
                $val["type"] = "u";
                $val["name"] = $dictunit[$spl[1]];
                $n++;
            } else if ($spl[0] == 'h' && isset($dictuser[$spl[1]])) {
                $val["type"] = "h";
                $val["name"] = $dictuser[$spl[1]];
                $n++;
            } else {
                $val["type"] = "-";
                $val = $i;
            }

            if ($validate) {
                $secondunit[$k] = $val;
            }
        }

        $priority = $type = DB::table('priority')->where('id', '=', $data->priority)->get()->first();
        $viphuman = Viphuman::orderBy('created_at', 'DESC')->where('id', '=', $data->conductor)->get()->first();

        $datajson = [
            'content' => $data->content,
            'source' => $data->source,
            'unit' => $firstunit,
            'deadline' => $data->deadline,
            'follow' => $secondunit,
            'note' => $data->note,
            'status' => $data->status,
            'priority' => isset($priority) ? [$data->priority, $priority->name] : [$data->priority],
            'steer_time' => date("d/m/Y", strtotime($data->steer_time)),
            'progress' => $data->progress,
            'conductor' => isset($viphuman) ? [$data->conductor, $viphuman->name] : [$data->conductor],
            'created_by' => isset($dictuser[$data->created_by]) ? $dictuser[$data->created_by] : '',
            'created_at' => date_format($data->created_at, 'd/m/Y'),
            'updated_at' => $data->updated_at,
            'complete_time' => $data->complete_time,
            'manager' => isset($dictuser[$data->manager]) ? $dictuser[$data->manager] : '',
            'unitnote' => $data->unitnote,
            'steeringSourceIds' => $steeringSourceIds,
            'steeringSourceNotes' => $steeringSourceNotes,
        ];


        return response()->json($datajson);

    }

    public function editProgress(Request $request)
    {
        $steering_id = intval($request->edit_steering_id);
        $progress_log_id = intval($request->edit_progress_id);
        $note = $request->edit_pr_note;
        $time_log = Utils::dateformat($request->edit_time_log);
        $data = array();
        $data['note'] = $note;
        $data['time_log'] = $time_log;

        $content = array();
        $update_content = false;
        $arr_log = DB::table('progress_log')->where('steeringcontent', $steering_id)->orderBy('id', 'desc')->get();
        if ($arr_log[0]->id == $progress_log_id) {
            $content['progress'] = $note;
            $update_content = true;
        }
        $selecr_log = DB::table('progress_log')->where('id', $progress_log_id)->first();
        if ($selecr_log->status == 1) {
            $content['complete_time'] = $time_log;
        }

        try {
            Progress::where('id', $progress_log_id)->update($data);
            Steeringcontent::where('id', $steering_id)->update($content);
            MLogs::write(Constant::$ACTION_UPDATE, 'progress_log', $progress_log_id, '');
        } catch (Exception $e) {
            return response()->json(array("error" => 'Caught exception: ', $e->getMessage(), "\n"));
        }

        $result = [
            'data' => $data,
            'content' => $content,
            'update' => $update_content
        ];

        return response()->json($result);
    }

    public function addProgress(Request $request)
    {
        $steering_id = $request->steering_id;
        $note = $request->note;
        $status = intval($request->pr_status);
        $time_log = Utils::dateformat($request->time_log);
        $data = array();
        $data['created_by'] = Auth::user()->id;
        $data['steeringcontent'] = $steering_id;
        $data['note'] = $note;
        $data['time_log'] = $time_log;
        $data['status'] = $status;
        $content = array();
        $content['progress'] = $note;
        $content['status'] = $status;
        if ($status == 1) {
            $content['complete_time'] = $time_log;
        }
        $file = $request->file('file');
        if (isset($file)) {
            $data['file_attach'] = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        }
        try {
            $result1 = DB::table('progress_log')->insertGetId($data);
            $result2 = Steeringcontent::where('id', $steering_id)->update($content);
            if (isset($file)) {
                $file_attach = "status_file_" . $result1 . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $destinationPath = 'file';
                $file->move($destinationPath, $file_attach);
            }
            MLogs::write(Constant::$ACTION_CREATE, 'progress_log', $result1, '');
        } catch (Exception $e) {
            return response()->json(array("error" => 'Caught exception: ', $e->getMessage(), "\n"));
        }
        return response()->json($content);
    }

    //unit note
    public function getUnitNote(Request $request)
    {
        $steering_id = intval($request->s);
        $progress = DB::table('unit_note')
            ->join('user', 'user.id', '=', 'unit_note.created_by')
            ->where('steeringcontent', '=', $steering_id)
            ->select('unit_note.*', 'user.fullname as created')
            ->orderBy('unit_note.id', 'desc')
            ->get();
        return response()->json($progress);
    }


    public function addUnitNote(Request $request)
    {
        $steering_id = $request->steering_id;
        $note = $request->note;
        $status = intval($request->pr_status);
        $time_log = Utils::dateformat($request->time_log);
        $data = array();
        $data['created_by'] = Auth::user()->id;
        $data['steeringcontent'] = $steering_id;
        $data['note'] = $note;
        $data['time_log'] = $time_log;
        $content = array();
        $content['unitnote'] = $note;
        try {
            $result1 = DB::table('unit_note')->insertGetId($data);
            $result2 = Steeringcontent::where('id', $steering_id)->update($content);
        } catch (Exception $e) {
            return response()->json(array("error" => 'Caught exception: ', $e->getMessage(), "\n"));
        }
        return response()->json($content);
    }

    //conductor note
    public function getConductorNote(Request $request)
    {
        $steering_id = intval($request->s);
        $progress = DB::table('conductor_note')
            ->join('user', 'user.id', '=', 'conductor_note.created_by')
            ->where('steeringcontent', '=', $steering_id)
            ->select('conductor_note.*', 'user.fullname as created')
            ->orderBy('conductor_note.id', 'desc')
            ->get();
        return response()->json($progress);
    }


    public function addConductorNote(Request $request)
    {
        $steering_id = $request->steering_id;
        $note = $request->note;
        $time_log = Utils::dateformat($request->time_log);
        $data = array();
        $data['created_by'] = Auth::user()->id;
        $data['steeringcontent'] = $steering_id;
        $data['note'] = $note;
        $data['time_log'] = $time_log;
        $content = array();
        $content['conductornote'] = $note;
        try {
            DB::table('conductor_note')->insertGetId($data);
            Steeringcontent::where('id', $steering_id)->update($content);
        } catch (Exception $e) {
            return response()->json(array("error" => 'Caught exception: ', $e->getMessage(), "\n"));
        }
        return response()->json($data);
    }

    #api tranfer
    public function tranfer(Request $request)
    {
//        return response()->json($request);
        $sender = Auth::id();
        $receiver = $request->receiver;
        $steering = $request->sid;
        $note = $request->note;

        $users = array();
        $select_user = DB::table('user')->get();
        foreach ($select_user as $row) {
            $users[$row->id] = $row;
        }
        $progress_note = 'Anh/chị ' . $users[$sender]->fullname . ' đã chuyển nhiệm vụ.';
        #update nhiem vu
        $dt_update = array();
        $dt_update['manager'] = $receiver;
        if ($users[$receiver]->conductor != null){
            $dt_update['conductor'] = $users[$receiver]->conductor;
        }
        $update = DB::table('steeringcontent')->where('id', '=', $steering)
            ->update($dt_update);
        if (!$update) {
            return response()->json(['result' => false,
                'mess' => 'Nhiệm vụ không tồn tại hoặc không do tài khoản anh/chị quản lý'
            ]);
        }
        #ghi log tranfer
        DB::table('tranfer_log')->insert([
            'sender' => $sender,
            'receiver' => $receiver,
            'steering' => $steering,
            'note' => $note,
            'time_log' => date('Y-m-d')
        ]);
        #ghi log tien do
        DB::table('progress_log')->insert([
            'created_by' => $sender,
            'time_log' => date('Y-m-d'),
            'steeringcontent' => $steering,
            'note' => $progress_note
        ]);
        return response()->json(['result' => true,
            'mess' => 'Nhiệm vụ chuyển thành công',
            'conductor' => $users[$receiver]->conductor
        ]);
    }

    #end api

    public function updatePosition(Request $request)
    {
        $listId = $request->listId;
        $ids = explode('-', $listId);
        foreach ($ids as $index => $id) {
            DB::table('type')->where('id', '=', $id)->update(['_order' => $index + 1]);
        }
        return response()->json(['result' => true,
            'mess' => 'Đổi vị trí thành công'
        ]);
    }

    public function sendEmail(Request $request){
        $data = array('name'=>"Cao Hoàng Tiến");
        Mail::send('mail', $data, function($message) {
            $message->to('tiench189.hut@gmail.com', 'Tiến Cao')->subject
            ('Laravel HTML Testing Mail');
            $message->from('caotien189@gmail.com','Cao Hoàng Tiến');
        });
        echo "Basic Email Sent. Check your inbox.";
    }

    public function formatUnit(Request $request)
    {
        $khacid = Unit::where('shortname', "KHAC")->pluck('id')->toArray()[0];
        $allsteering = DB::table('steeringcontent')->get();
        $tempdata = array();
        foreach ($allsteering as $steering) {
            $arrunit = explode(',', $steering->unit);
            $unit = "";
            foreach ($arrunit as $idx => $u) {
                if ($u != "") {
                    if (!strpos($u, "|")) {
                        if (!isset($tempdata[$u])) {
                            $words = explode(" ", Utils::stripUnicode($u));
                            $letters = "";
                            foreach ($words as $value) {
                                $letters .= substr($value, 0, 1);
                            }
                            $newuid = Unit::insertGetId([
                                'name' => $u,
                                'shortname' => strtoupper($letters),
                                'parent_id' => $khacid,
                            ]);
                            $unit .= "u|" . $newuid . ",";
                            $tempdata[$u] = "u|" . $newuid;
                        } else {
                            $unit .= $tempdata[$u] . ',';
                        }
                    } else {
                        $unit .= $u . ',';
                    }
                }
            }

            $arrfollow = explode(',', $steering->follow);
            $follow = "";
            foreach ($arrfollow as $idx => $u) {
                if ($u != "") {
                    if (!strpos($u, "|")) {
                        if (!isset($tempdata[$u])) {
                            $words = explode(" ", Utils::stripUnicode($u));
                            $letters = "";
                            foreach ($words as $value) {
                                $letters .= substr($value, 0, 1);
                            }
                            $newuid = Unit::insertGetId([
                                'name' => $u,
                                'shortname' => strtoupper($letters),
                                'parent_id' => $khacid,
                            ]);
                            $follow .= "u|" . $newuid . ",";
                            $tempdata[$u] = "u|" . $newuid;
                        } else {
                            $follow .= $tempdata[$u] . ',';
                        }
                    } else {
                        $follow .= $u . ',';
                    }
                }
            }

            DB::table('steeringcontent')->where('id', '=', $steering->id)->update(['unit' => $unit, 'follow' => $follow]);
        }
    }

    //Kiem tra trung lap
    public function checkDuplicate(Request $request){
        $id = intval($request->id);
        $content = $request->mycontent;
        $steerings = DB::table('steeringcontent')->get();
        $duplicate = array();
        foreach ($steerings as $row){
            if ($row->id != $id && Utils::compareSteer($content, $row->content)){
                $duplicate[] = $row;
            }
        }
        if (count($duplicate) > 0){
            return response()->json(['result' => false,
                'data' => $duplicate
            ]);
        }else{
            return response()->json(['result' => true]);
        }
    }
}
