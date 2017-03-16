<?php

namespace App\Http\Controllers;

use App\user;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data=User::orderBy('created_at', 'DESC')->get();
        return view("user/index")->with('nguoidung',$data);

    }

    public function edit(Request $request)
    {
        $id = intval( $request->input('id') );
        if($id > 0) {
            $data=User::where('id',$id)->get();
            return view("user/update")->with('nguoidung',$data);
        } else {
            return view("user/add");
        }
    }

    public function update(Request $request)
    {

        $id = intval( $request->input('id') );
        if($id > 0) {
            $result=User::where('id',$request->input('id'))->update([
                'username'=>$request->input('username'),
                'password'=>$request->input('password'),
                'fullname'=>$request->input('fullname'),
            ]);

            $data=User::where('id',$request->input('id'))->get();

            return redirect()->action(
                'UserController@index', ['update' => $result]
            );

        } else {

            $result=User::insert([
                'username'=>$request->input('username'),
                'password'=>$request->input('password'),
                'fullname'=>$request->input('fullname'),
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


