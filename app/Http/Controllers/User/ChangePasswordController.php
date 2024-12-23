<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\ChangePasswordRequest;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\User;


class ChangePasswordController extends Controller
{

    public function index() {
        return view('admin.user.user.changePassword');
    }


    public function update(ChangePasswordRequest $request,$id){
        $input['password'] = Hash::make($request['password']);
        if(Auth::attempt(['user_id'=>Auth::user()->user_id,'password'=>$request->oldPassword])){
               User::where('user_id', Auth::user()->user_id)->update($input);
              return redirect()->back()->with('success', 'Password successfully updated.');
        }else{
            return redirect()->back()->with('error', 'Old Password does not match.');
        }
    }



}
