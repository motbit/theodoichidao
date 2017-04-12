<?php

namespace App\Http\Controllers;

use App\Group;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index()
    {
        if (!\App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())) {
            return redirect('/errpermission');
        }
        $group = Group::orderBy('created_at', 'DESC')->get();
        return view('group.index', ['group' => $group]);
    }

    public function edit(Request $request)
    {
        $id = intval($request->input('id'));
        if ($id > 0) {
            $data = Group::where('id', $id)->get();
            return view("group.update", ['data' => $data, 'id' => $id]);
        } else {
            return view("group.update", ['id' => $id]);
        }
    }

    public function update(Request $request)
    {
        $id = intval($request->input('id'));
        $description = $request->input('description');
        if ($id > 0) {
            Group::where('id', $id)->update(['description' => $description]);
            $request->session()->flash('message', "<strong>Cập nhật Nhóm người sử dụng thành công</strong>.");
            $request->session()->flash('gid', $id);

        } else {
            $gid = Group::insertGetId(['description' => $description]);
            $request->session()->flash('message', "<strong>Thêm Nhóm người sử dụng thành công</strong>.");
            $request->session()->flash('gid', $gid);

        }
        return redirect()->action('GroupController@index');

    }

    public function delete(Request $request)
    {
        $id = intval($request->input('id'));

        $st_count2 = User::Where([['group', '=', $id]])->count();
        if ($st_count2 > 0) {
            $request->session()->flash('message', "<strong>Bạn không thể xóa Nhóm này.</strong><br /> Vui xóa bỏ <u>Người sử dụng</u> thuộc nhóm này trước khi xóa <u>Nhóm</u>.");
        } else {
            $request->session()->flash('message', "<strong>Xóa Nhóm Người sử dụng thành công.</strong> <br /> #ID Nhóm Người Sử Dụng: <strong>" . $id . "</strong>");
            Group::where('id', $id)->delete();
        }

        return redirect()->action('GroupController@index');
    }

    //Permisson

    public function editPermission(Request $request)
    {
        $id = intval($request->input('id'));
        $group = DB::table('group')->where('id', '=', $id)->first();

        $datapermission = DB::table('group_permission')
            ->where('group', '=', $id)
            ->get();
        $permission = array();
        foreach ($datapermission as $row) {
            $permission[$row->view] = $row;
        }

        $dataview = DB::table('views')->orderBy('_order', 'ASC')->get();
        $views = array();
        foreach ($dataview as $row) {
            $views[$row->id] = $row->name;
        }
        $dictionary = array();
        $dictionary['add'] = "Thêm mới";
        $dictionary['edit'] = "Chỉnh sửa";
        $dictionary['delete'] = "Xóa";
        $dictionary['status'] = "Cập nhật tiến độ";
        $dictionary['trans'] = "Chuyển";
        $dictionary['role'] = "Phân quyền";

        return view("group.permission", ['id' => $id, 'permission' => $permission, 'views' => $views,
            'group' => $group, 'dataview' => $dataview, 'dictionary' => $dictionary]);
    }

    public function updatePermission(Request $request)
    {
        $id = intval($request->input('id'));
        $view = $request->input('view');
        $dataview = DB::table('views')->orderBy('_order', 'ASC')->get();
        foreach ($dataview as $row) {
            if (in_array('' . $row->id, $view)) {
                $action = "";
                $arraction = $request->input('action-' . $row->id);
                if (is_array($arraction)) {
                    foreach ($arraction as $ac) {
                        $action .= "(" . $ac . ")";
                    }
                }
                $exist = DB::table('group_permission')->where([['group', '=', $id],
                    ['view', '=', $row->id]])->get();
                if (count($exist) > 0) {
                    DB::table('group_permission')->where([['group', '=', $id],
                        ['view', '=', $row->id]])->update(['action' => $action]);
                } else {
                    DB::table('group_permission')->insert([
                        'group' => $id,
                        'view' => $row->id,
                        'action' => $action
                    ]);
                }
            } else {
                DB::table('group_permission')->where([['group', '=', $id],
                    ['view', '=', $row->id]])->delete();
            }
        }
        $request->session()->flash('message', "<strong>Cập nhật quyền thành công!</strong>.");
        return redirect()->action('GroupController@editPermission', ['id' => $id]);
    }
}


