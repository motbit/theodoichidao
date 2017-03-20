<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Sourcesteering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SourcesteeringController extends Controller
{
    public function index()
    {
        if (!Auth::check()){
            return redirect("login");
        }
        if (!Roles::checkPermission()){
            return redirect("xuly/duocgiao");
        }
        $data = DB::table('sourcesteering')
            ->join('type', 'sourcesteering.type', '=', 'type.id')
            ->select('sourcesteering.*', 'type.name as typename')
            ->get();
        $type = DB::table('type')
            ->select('name')
            ->get();

        return view("sourcesteering/index", ['data' => $data, 'type' => $type]);

    }

    public function edit(Request $request)
    {
        if (!Auth::check()){
            return redirect("login");
        }
        $type = DB::table('type')->get();
        $conductor = DB::table('viphuman')->get();
        $id = intval($request->input('id'));
        if ($id > 0) {
            $steering = DB::table('sourcesteering')
                ->where('id', '=', $id)
                ->get()->first();
            return view("sourcesteering/add", ['type' => $type, 'conductor' => $conductor, 'id' => $id, 'steering' => $steering]);
        } else {
            return view("sourcesteering/add", ['type' => $type, 'conductor' => $conductor, 'id' => $id]);
        }
    }

    public function update(Request $request)
    {
        if (!Auth::check()){
            return redirect("login");
        }
        $id = intval($request->input('id'));
//        dd($request->file('docs'));
        $status = 0;
        $file_attach = "";
        $file = $request->file('docs');
        if (isset($file)){
            $file_attach = $request->input('code') . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $file_attach = str_replace("/", "-", $file_attach);

        }
        if ($request->input('complete') != null) {
            $status = 1;
        }
        if ($id > 0) {
            $update = [
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'code' => $request->input('code'),
                'sign_by' => $request->input('sign_by'),
                'status' => $status,
                'time' => \DateTime::createFromFormat('d/m/Y', $request->input('time'))
            ];
            if (isset($file)){
                $update['file_attach'] = $file_attach;
            }
            $result=Sourcesteering::where('id',$id)->update($update);
        } else {
            $result = Sourcesteering::insert([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'code' => $request->input('code'),
                'sign_by' => $request->input('sign_by'),
                'file_attach' => $file_attach,
                'status' => $status,
                'time' => \DateTime::createFromFormat('d/m/Y', $request->input('time')),
            ]);
        }
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

    #region Nguoidung Delete
    public function delete(Request $request)
    {
        if (!Auth::check()){
            return redirect("login");
        }
        $result = Sourcesteering::where('id', $request->input('id'))->delete();
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

    #endregion


}


