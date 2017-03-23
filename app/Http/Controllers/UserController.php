<?php

namespace App\Http\Controllers;

use App\User;
use App\Unit;
use App\Group;
use Validator;
use Illuminate\Http\Request;


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
            $group[$row->id] = $row->name;
        }

        $data=User::orderBy('created_at', 'DESC')->get();
        return view('user.index',['unit'=>$unit,'group'=>$group,'nguoidung'=>$data]);


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
            $group[$row->id] = $row->name;
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
            'username.min' => 'Tên người dùng phải ít nhất 6 chữ cái.',
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
                'username' => 'required|unique:user,username|alpha_num|min:5|max:20',
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


