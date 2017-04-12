<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Steeringcontent;
use App\Utils;
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
