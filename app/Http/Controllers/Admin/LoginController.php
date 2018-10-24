<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    //
    /*登录*/
    public function login(){
        if($input=Input::all()){
            $rules = [
                "user_name" => 'required',
                "user_pass" => 'required',
            ];
            $messages = [
                'user_name.required' => '用户名不能为空',
                'user_pass.required' => '密码不能为空'
            ];

            $validator = Validator::make(Input::all(), $rules, $messages);
            if($validator->fails()) {
                return back()->withErrors($validator);
            } else {

                $adminUser=AdminUsers::where(['user_name'=>$input['user_name']])->first();
                if(Crypt::decrypt($adminUser->user_pass)==$input['user_pass']){
                    session(['user_name'=>$input['user_name']]);
                    return redirect('admin/index');
                }else{
                    return redirect("admin/login/login");
                }

            }
        }

        return view("admin/login/login");
    }

    public function logout(){
        session(['user_name'=>null]);
        return redirect("admin/login");
    }

    public function resetPassword()
    {
        AdminUsers::where("id",1)->update(['user_pass'=>Crypt::encrypt("admin")]);
        echo 1;
    }
}
