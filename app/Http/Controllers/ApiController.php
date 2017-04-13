<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Steeringcontent;
use App\Sourcesteering;
use App\Viphuman;
use App\User;
use App\Utils;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $result1 = Progress::insert($data);
            $result2 = Steeringcontent::where('id', $steering_id)->update($content);
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
        $priority = $type = DB::table('priority')->get();
        $viphuman = Viphuman::orderBy('created_at', 'DESC')->get();
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
        foreach($units = explode(',', $data->unit) as $k=>$i) {
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
        foreach($units = explode(',', $data->follow) as $k=>$i) {

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


        $datajson = [
            'source' => $data->source,
            'unit' => $firstunit,
            'deadline' => $data->deadline,
            'follow' => $secondunit,
            'note' => $data->note,
            'status' => $data->status,
            'priority' => $data->priority,
            'steer_time' => $data->steer_time,
            'progress' => $data->progress,
            'conductor' => $data->conductor,
            'created_by' => $data->created_by,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'complete_time' => $data->complete_time,
            'manager' => $data->manager,
            'unitnote' => $data->unitnote,
            'steeringSourceIds' => $steeringSourceIds,
            'steeringSourceNotes' => $steeringSourceNotes,
        ];


        return response()->json($datajson);

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
            $users[$row->id] = $row->fullname;
        }
        $progress_note = 'Anh/chị ' . $users[$sender] . ' chuyển nhiệm vụ cho anh/chị ' . $users[$receiver];
        #update nhiem vu
        $update = DB::table('steeringcontent')->where('id', '=', $steering)
            ->update(['manager' => $receiver, 'progress' => $progress_note]);
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
            'mess' => 'Nhiệm vụ chuyển thành công'
        ]);
    }
    #end api

    public function updatePosition(Request $request){
        $listId = $request->listId;
        $ids = explode('-', $listId);
        foreach ($ids as $index => $id){
            DB::table('type')->where('id', '=', $id)->update(['_order'=>$index+1]);
        }
        return response()->json(['result'=>true,
            'mess'=>'Đổi vị trí thành công'
        ]);
    }
}
