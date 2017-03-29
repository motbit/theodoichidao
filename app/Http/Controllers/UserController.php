<?php

namespace App\Http\Controllers;

use App\User;
use App\Unit;
use App\Group;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (! \App\Roles::accessView(\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri())){
            return redirect('/errpermission');
        }
        $unitdata=Unit::orderBy('created_at', 'DESC')->get();
        $unitgroup=Group::orderBy('created_at', 'DESC')->get();

        $unit = array();
        $group = array();

        foreach ($unitdata as $row) {
            $unit[$row->id] = $row->name;
        }

        foreach ($unitgroup as $row) {
            $group[$row->id] = $row->description;
        }

        $data=User::orderBy('created_at', 'DESC')->get();
        return view('user.index',['unit'=>$unit,'group'=>$group,'nguoidung'=>$data]);


    }

    public function changepass(Request $request){
        $id = 6;
        if($request->input('old-password')){
            $credentials = [
                'username' => 'admin',
                'password' => $request->input('old-password'),
            ];
            if(\Auth::validate($credentials)) {
                $result = User::where('id', $id)->update([
                    'password'=>  bcrypt($request->input('password')),
                ]);
                return redirect()->action(
                    'UserController@index', ['add' => 1]
                );
            }else{
                $request->session()->flash('message', "Mật khẩu cũ không đúng");
                return redirect()->action(
                    'UserController@changepass'
                );
            }
        }
        $data = User::where('id',$id)->get();
        return view('user.changepass',['data'=>$data[0], 'id'=>$id]);
    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );

        $unitdata=Unit::orderBy('created_at', 'DESC')->get();
        $unitgroup=Group::orderBy('created_at', 'DESC')->get();

        $unit = array();
        $group = array();

        foreach ($unitdata as $row) {
            $unit[$row->id] = $row->name;
        }
        foreach ($unitgroup as $row) {
            $group[$row->id] = $row->description;
        }

        if($id > 0) {
            $data=User::where('id',$id)->get();

            return view('user.update',['unit'=>$unit,'group'=>$group,'nguoidung'=>$data]);

        } else {
            return view('user.add',['unit'=>$unit,'group'=>$group]);
        }
    }

    public function update(Request $request)
    {

        $id = intval( $request->input('id') );

        $messages = [
            'username.min' => 'Tên người dùng phải ít nhất 4 chữ cái.',
            'username.alpha' => 'Tên người dùng chỉ bao gồm các chữ cái và số.',
            'username.required' => 'Yêu cầu nhập tên người dùng.',
            'username.unique' => 'Tên người dùng đã tồn tại.',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự.',
            'password.required' => 'Yêu cầu nhập mật khẩu.',
        ];
        if($id > 0) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|nullable|min:6',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('UserController@update',["id"=>$id])
                    ->withErrors($validator)
                    ->withInput();
            }

        } else {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:user,username|alpha_num|min:4|max:20',
                'password' => 'required|min:6',
                'group' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect()->action('UserController@update')
                    ->withErrors($validator)
                    ->withInput();
            }

        }

        if($id > 0) {

            $data = [
                'fullname'=>$request->input('fullname'),
                'group'=>$request->input('group'),
                'unit'=>$request->input('unit'),
            ];

            if(strlen($request->input('password')) >= 6) {
                $data['password'] = bcrypt($request->input('password'));
            }

            $result=User::where('id',$request->input('id'))->update($data);

            if($result) {
                $request->session()->flash('message', "Cập nhật <b>#" . $id . ". " . $request->input('username') . "</b> thành công!");
            } else {
                $request->session()->flash('message', "Cập nhật <b>#" . $id . ". " . $request->input('fullname') . " </b>không thành công!");
            }

            return redirect()->action(
                'UserController@index', ['update' => $result]
            );

        } else {
            $result=User::insert([
                'username'=>$request->input('username'),
                'password'=>bcrypt($request->input('password')),
                'fullname'=>$request->input('fullname'),
                'group'=>$request->input('group'),
                'unit'=>$request->input('unit'),
            ]);

            if($result) {
                $request->session()->flash('message', "Thêm người dùng mới thành công!");
            } else {
                $request->session()->flash('message', "Thêm người dùng mới thất bại!");
            }

            if($result) {
                return redirect()->action(
                    'UserController@index', ['add' => 1]
                );
            } else {
                return redirect()->action(
                    'UserController@update', ['error' => 1]
                );
            }
        }

    }

    #region Nguoidung Delete
    public function delete(Request $request)
    {

        $result=User::where('id',$request->input('id'))->delete();
        if($result) {
            return redirect()->action(
                'UserController@index', ['delete' => $request->input('id')]
            );
        } else {
            return redirect()->action(
                'UserController@index', ['delete' => "0:".$request->input('id')]
            );
        }
    }
    #endregion

}


