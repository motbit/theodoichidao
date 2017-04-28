<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Steeringcontent;
use App\Unit;
use App\Sourcesteering;
use App\User;
use App\Utils;
use App\Viphuman;
use App\Steering_source;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;
use Validator;

class SteeringcontentController extends Controller
{
    public function index(Request $request)
    {
        $role = \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri());
        if (!$role) {
            if(Roles::accessView("xuly/daumoi")){
                return redirect("xuly/daumoi");
            }
            return redirect('/errpermission');
        }
        $request->session()->put('steering_url', $request->getRequestUri());
        $type = $request->input('type');
        $source = $request->input('source');
        $conductor = $request->input('conductor');
        $thisconductor = false;
        $steering = false;
        $sourceinfo = false;
        $param = "";
        if ($source || $type || $conductor) {

            if ($source) {
                $steering = DB::table('sourcesteering')
                    ->where('code', '=', $source)
                    ->get()->first();
                $data = DB::table('steeringcontent')
                    ->where('source', 'like', '%|' . $source . "|%")
                    ->orderBy('id', 'DESC')->get();
            } else if ($conductor) {
                $param = "c" . $conductor;
                $data = DB::table('steeringcontent')
                    ->where('conductor', '=', $conductor)
                    ->orderBy('id', 'DESC')->get();
                $thisconductor = DB::table('viphuman')
                    ->where('id', '=', $conductor)
                    ->get()->first();
            } else if ($type) {
                $param = "t" . $type;
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
            $data = Steeringcontent::orderBy('id', 'DESC')
                ->get();
        }


        $dataunit = Unit::orderBy('created_at', 'DESC')->get();
        $datauser = User::orderBy('fullname', 'ASC')->get();

        $firstunit = array();
        $user = array();

        foreach ($dataunit as $row) {
            $firstunit[$row->id] = $row->name;
        }

        foreach ($datauser as $row) {
            $user[$row->id] = $row->fullname;
        }

        $viphuman = Viphuman::orderBy('created_at', 'DESC')->get();

        $conductor = array();
        foreach ($viphuman as $row) {
            $conductor[$row->id] = $row->name;
        }
        return view('steeringcontent.index', ['lst' => $data, 'unit' => $firstunit,
            'steering' => $steering, 'user' => $user, 'dtconductor' => $conductor,
            'conductor' => $thisconductor, 'sourceinfo' => $sourceinfo,
            "datauser" => $datauser, 'parram' => $param, 'role' => $role, 'viphuman' => $viphuman]);
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

            //get list source id
            $steeringSources = DB::table('steering_source')->select('source', 'note')->where('steering', $id)->get();
            $steeringSourceIds = array();
            $steeringSourceNotes = array();
            foreach ($steeringSources as $key => $sc) {
                $steeringSourceIds[$key] = $sc->source;
                $steeringSourceNotes[$sc->source] = $sc->note;
            }

            return view('steeringcontent.update', ['dictunit' => $dictunit, 'source' => $source,
                'data' => $data, 'dtfollowArr' => $dtfollowArr, 'dtUnitArr' => $dtUnitArr, 'sourcesteering' => $sourcesteering, 'treeunit' => $tree_unit, 'unit' => $unit,
                'priority' => $priority, 'viphuman' => $viphuman, 'user' => $user, 'type' => $type, 'steeringSourceIds' => $steeringSourceIds, 'steeringSourceNotes' => $steeringSourceNotes]);
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

        if (!empty($firstUnit)) {
            foreach ($firstUnit as $u) {
                if (preg_match('/[uh]\|\d+/', $u)) {
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

        if (!empty($secondunit)) {
            foreach ($secondunit as $u) {
                if (preg_match('/[uh]\|\d+/', $u)) {
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
        $priority = $request->input('priority');
        if (!isset($priority)) {
            $priority = 1;
        }

        if ($id > 0) {
            $noteArr = $request->input('note');
            $typeArr = $request->input('mtype');

            DB::beginTransaction();
            $result = Steeringcontent::where('id', $request->input('id'))->update([
                'content' => $request->input('content'),
//                'source' => '|' . implode('|', $request->input('msource')) . '|',
                'unit' => $fu,
                'follow' => $su,
                'steer_time' => Utils::dateformat($request->input('steer_time')),
                'deadline' => $deadline,
                'priority' => $request->input('priority'),
                'conductor' => $request->input('viphuman')
            ]);

            DB::table('steering_source')->where('steering', $request->input('id'))->delete();

            foreach ($typeArr as $key => $type) {
                $arr = explode('|', $type);
                $t = $arr[1];
                $k = $arr[0];
                $note = $noteArr[$k];

                $sc = Steering_source::insert([
                    'steering' => $request->input('id'),
                    'source' => $t,
                    'note' => $note,
                ]);
            }

            if (!$result || !$sc) {
                DB::rollback();
                $request->session()->flash('revertfilter', 1);
            } else {
                DB::commit();
                $request->session()->flash('revertfilter', 1);
            }

            if ($request->session()->has('steering_url')) {
                return redirect(Utils::formatAlias($request->session()->get('steering_url')));
            }
            return redirect()->action(
                'SteeringcontentController@index', ['update' => $result]
            );

        } else {
            $noteArr = $request->input('note');
            $typeArr = $request->input('mtype');


            DB::beginTransaction();

            $scid = DB::table('steeringcontent')->insertGetId(
                array(
                    'content' => $request->input('content'),
//                'source' => '|' . implode('|', $request->input('msource')) . '|',
                    'unit' => $fu,
                    'follow' => $su,
                    'priority' => $priority,
                    'conductor' => $request->input('viphuman'),
                    'steer_time' => Utils::dateformat($request->input('steer_time')),
                    'deadline' => $deadline,
                    'created_by' => Auth::user()->id,
                    'manager' => Auth::user()->id)
            );

            foreach ($typeArr as $key => $type) {
                $arr = explode('|', $type);
                $t = $arr[1];
                $k = $arr[0];
                $note = $noteArr[$k];

                $sc = Steering_source::insert([
                    'steering' => $scid,
                    'source' => $t,
                    'note' => $note,
                ]);
            }

            if (!$scid || !$sc) {
                DB::rollback();
                $request->session()->flash('revertfilter', 1);
            } else {
                // Else commit the queries
                DB::commit();
                $request->session()->flash('revertfilter', 1);
            }
            if ($request->session()->has('steering_url')) {
                return redirect(Utils::formatAlias($request->session()->get('steering_url')));
            }
            return redirect()->action(
                'SteeringcontentController@index'
            );

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


