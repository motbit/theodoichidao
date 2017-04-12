<?php

namespace App\Http\Controllers;

use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\User;
use App\Utils;
use App\Viphuman;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Validator;

class SteeringcontentController extends Controller
{
    public function index(Request $request)
    {
        if (!\App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())) {
            return redirect('/errpermission');
        }
        $type = $request->input('type');
        $source = $request->input('source');
        $conductor = $request->input('conductor');
        $thisconductor = false;
        $steering = false;
        $sourceinfo = false;
        $param = "";
        if ($source || $type || $conductor) {

            if($source) {
                $steering = DB::table('sourcesteering')
                    ->where('code', '=', $source)
                    ->get()->first();
                $data = DB::table('steeringcontent')
                    ->where('source', 'like', '%|'. $source . "|%")
                    ->orderBy('id', 'DESC')->get();
            } else if($conductor) {
                $param = "c".$conductor;
                $data = DB::table('steeringcontent')
                    ->where('conductor', '=', $conductor)
                    ->orderBy('id', 'DESC')->get();
                $thisconductor = DB::table('viphuman')
                    ->where('id', '=', $conductor)
                    ->get()->first();
            } else if ($type) {
                $param = "t".$type;
                $sourceinfo = DB::table('type')
                    ->where('id', '=', $type)
                    ->get()->first();
                $data = DB::table('steeringcontent')
                    ->join('steering_source', 'steeringcontent.id', '=', 'steering_source.steering')
                    ->join('type', 'steering_source.source', '=', 'type.id')
                    ->select('steeringcontent.*')
                    ->where('type.id', '=', $type)
                    ->orderBy('id', 'desc')
                    ->get();

            }


        } else {
            $steering = false;
            $sourceinfo = false;
            $data = Steeringcontent::orderBy('id', 'DESC')->get();
        }

        $allsteeringcode = DB::table('sourcesteering')->pluck('code');


        $dataunit = Unit::orderBy('created_at', 'DESC')->get();
        $datauser = User::orderBy('fullname', 'ASC')->get();

        $firstunit = array();
        $secondunit = array();
        $user = array();
        $user4tranfer = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
            $secondunit[$row->id] = $row->name;
        }

        foreach ($datauser as $row) {
            $user[$row->id] = $row->fullname;
        }

        $sourcesteering = Sourcesteering::orderBy('created_at', 'DESC')->get();
        $sources = array();
        foreach ($sourcesteering as $row) {
            if (trim($row->code) != '') {
                $sources[$row->id] = "" . $row->name . "";
            } else {
                $sources[$row->id] = "" . $row->code . "";
            }
        }
        $sourcetype = array();
        foreach ($sourcesteering as $row) {
            $sourcetype[$row->code] = "" . $row->type . "";
        }
        return view('steeringcontent.index', ['lst' => $data, 'unit' => $firstunit, 'unit2' => $secondunit, 'source' => $sources,
            'steering' => $steering, 'allsteeringcode' => $allsteeringcode->all(), 'user' => $user,
            'conductor' => $thisconductor, 'sourcetype' => $sourcetype, 'sourceinfo' => $sourceinfo,
            "datauser" => $datauser, 'parram' => $param]);
    }

    public function edit(Request $request)
    {
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

        $source = array();
        foreach ($sourcesteering as $row) {
            $source[$row->id] = $row->code;
        }
        $type = DB::table('type')->orderBy('_order', 'ASC')->get();
        if ($id > 0) {
            $data = Steeringcontent::where('id', $id)->get();

            $dtfollowArr = explode(",", $data[0]['follow']);
            $dtUnitArr = explode(",", $data[0]['unit']);

            return view('steeringcontent.update', ['dictunit' => $dictunit, 'source' => $source,
                'data' => $data, 'dtfollowArr' => $dtfollowArr, 'dtUnitArr' => $dtUnitArr, 'sourcesteering' => $sourcesteering, 'treeunit' => $tree_unit, 'unit' => $unit,
                'priority' => $priority, 'viphuman' => $viphuman, 'user' => $user, 'type' => $type]);
        } else {

            return view('steeringcontent.add', ['sourcesteering' => $sourcesteering, 'dictunit' => $dictunit,
                'treeunit' => $tree_unit, 'unit' => $unit, 'priority' => $priority, 'viphuman' => $viphuman,
                'user' => $user, 'type' => $type]);
        }
    }

    public function update(Request $request)
    {

        $id = intval($request->input('id'));
        $messages = [
            'content.required' => 'Yêu cầu nhập trích yếu',
        ];
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->action('SteeringcontentController@update', ["id" => $id])
                ->withErrors($validator)
                ->withInput();
        }
        $deadline = Utils::dateformat($request->input('deathline'));
        if (!$deadline) $deadline = null;

        // Kiem tra Don Vi Dau Moi / Don Vi Phoi Hop
        // Neu khong co thi Them moi va set Parrent id=5

        $khacid = Unit::where('shortname', "KHAC")->pluck('id')->toArray()[0];


        $firstUnit = $request->input('firtunit');
        $fu = "";

        if(!empty($firstUnit)) {
            foreach ($firstUnit as $u) {
                if(preg_match('/[uh]\|\d+/',$u)) {
                    $fu .= $u . ",";
                } else {

                    $words = explode(" ", Utils::stripUnicode($u));
                    $letters = "";
                    foreach ($words as $value) {
                        $letters .= substr($value, 0, 1);
                    }
                    // Them Unit moi neu khong ton tai
                    $newuid = Unit::insertGetId([
                        'name' => $u,
                        'shortname' => strtoupper($letters),
                        'parent_id' => $khacid,
                    ]);

                    $fu .= "u|" . $newuid . ",";
                }

            }

        }
        $secondunit = $request->input('secondunit');

        $su = "";

        if(!empty($secondunit)) {
            foreach ($secondunit as $u) {
                if(preg_match('/[uh]\|\d+/',$u)) {
                    $su .= $u . ",";
                } else {

                    $words = explode(" ", Utils::stripUnicode($u));
                    $letters = "";
                    foreach ($words as $value) {
                        $letters .= substr($value, 0, 1);
                    }
                    // Them Unit moi neu khong ton tai
                    $newuid = Unit::insertGetId([
                        'name' => $u,
                        'shortname' => strtoupper($letters),
                        'parent_id' => $khacid,
                    ]);

                    $su .= "u|" . $newuid . ",";
                }

            }
        }

        if ($id > 0) {

            $result = Steeringcontent::where('id', $request->input('id'))->update([
                'content' => $request->input('content'),
                'source' => '|' . implode('|', $request->input('msource')) . '|',
                'unit' => $fu,
                'follow' => $su,
                'steer_time' => Utils::dateformat($request->input('steer_time')),
                'deadline' => $deadline,
                'conductor' => $request->input('viphuman')
            ]);

            $data = Steeringcontent::where('id', $request->input('id'))->get();

            return redirect()->action(
                'SteeringcontentController@index', ['update' => $result]
            );

        } else {
            $result = Steeringcontent::insert([
                'content' => $request->input('content'),
                'source' => '|' . implode('|', $request->input('msource')) . '|',
                'unit' => $fu,
                'follow' => $su,
                'priority' => $request->input('priority'),
                'conductor' => $request->input('viphuman'),
                'steer_time' => Utils::dateformat($request->input('steer_time')),
                'deadline' => $deadline,
                'created_by' => Auth::user()->id,
                'manager' => Auth::user()->id,
            ]);

            if ($result) {
                return redirect()->action(
                    'SteeringcontentController@index', ['add' => 1]
                );
            } else {
                return redirect()->action(
                    'SteeringcontentController@index', ['error' => 1]
                );
            }
        }
    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result = Steeringcontent::where('id', $request->input('id'))->delete();
        if ($result) {
            return redirect()->action(
                'SteeringcontentController@index', ['delete' => $request->input('id')]
            );
        } else {
            return redirect()->action(
                'SteeringcontentController@index', ['delete' => "0:" . $request->input('id')]
            );
        }
    }
    #endregion


}


