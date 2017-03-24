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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('user')->get();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProgress(Request $request)
    {
        $steering_id = intval($request->s);
        $progress = DB::table('progress_log')
            ->join('user', 'user.id', '=', 'progress_log.created_by')
            ->where('steeringcontent', '=', $steering_id)
            ->select('progress_log.*', 'user.fullname as created')
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
        $result1 = Progress::insert($data);
        $result2 = Steeringcontent::where('id', $steering_id)->update($content);
        return response()->json($content);
    }
}
