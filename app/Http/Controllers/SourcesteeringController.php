<?php

namespace App\Http\Controllers;

use App\Sourcesteering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SourcesteeringController extends Controller
{
    public function index()
    {
        $data = DB::table('sourcesteering')
            ->join('type', 'sourcesteering.type', '=', 'type.id')
            ->join('viphuman', 'sourcesteering.conductor', '=', 'viphuman.id')
            ->select('sourcesteering.*', 'type.name as typename', 'viphuman.name as conductorname')
            ->get();
        return view("sourcesteering/index")->with('data', $data);

    }

    public function edit(Request $request)
    {
        $type = DB::table('type')->get();
        $conductor = DB::table('viphuman')->get();
        $id = intval($request->input('id'));
        if ($id > 0) {
        } else {
            return view("sourcesteering/add", ['type' => $type, 'conductor' => $conductor]);
        }
    }

    public function update(Request $request)
    {
        $id = intval($request->input('id'));
//        dd($request->file('docs'));
        $status = 0;
        $file_attach = "";
        $file = $request->file('docs');
        if (isset($file)){
            $file_attach = $request->input('code') . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        }
        if ($request->input('complete') != null) {
            $status = 1;
        }
//        dd($file);
        if ($id > 0) {

        } else {
            $result = Sourcesteering::insert([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'code' => $request->input('code'),
                'conductor' => $request->input('conductor'),
                'file_attach' => $file_attach,
                'status' => $status,
                'time' => $request->input('time'),
            ]);
//            dd($result);
            if (isset($file)) {
                $destinationPath = 'file';
                $file->move($destinationPath, $file_attach);
            }
            if ($result) {
                return redirect()->action(
                    'SourcesteeringController@index', ['add' => 1]
                );
            } else {
                return redirect()->action(
                    'SourcesteeringController@index', ['error' => 1]
                );
            }
        }
    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result = Sourcesteering::where('id', $request->input('id'))->delete();
    }

    #endregion


}


