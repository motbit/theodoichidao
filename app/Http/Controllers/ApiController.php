<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Steeringcontent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

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
        $time_log = \DateTime::createFromFormat('d/m/Y', $request->time_log);
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
        $time_log = \DateTime::createFromFormat('d/m/Y', $request->time_log);
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
}
