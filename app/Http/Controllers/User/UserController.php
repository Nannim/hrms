<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Repositories\CommonRepository;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserRequest;

use Illuminate\Http\Request;

use App\User;


class UserController extends Controller
{

    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository){
        $this->commonRepository = $commonRepository;
    }



    public function index(){
        $allUsers = User::with('role')->orderBy('user_id', 'desc')->get();
        return view('admin.user.user.index',['data'=>$allUsers]);
    }



    public function create(){
        $roleList = $this->commonRepository->roleList();
        return view('admin.user.user.add_user',['data'=>$roleList]);
    }



    public function store(UserRequest $request){

        unset($request['password_confirmation']);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;

        try{
            User::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('user')->with('success', 'User successfully saved.');
        } else {
            return redirect('user')->with('error', 'Something error found !, Please try again.');
        }
    }



    public function edit($id){
        $roleList = $this->commonRepository->roleList();
        $editModeData =User::FindOrFail($id);
        return view('admin.user.user.edit_user',['data'=>$roleList,'editModeData'=>$editModeData]);
    }



    public function update(UserRequest $request, $id){

        $data =User::FindOrFail($id);
        $input = $request->all();
        $input['created_by'] = Auth::user()->user_id;;
        $input['updated_by'] = Auth::user()->user_id;

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'User successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Something error found !, Please try again.');
        }
    }



    public function destroy($id) {
        try{
            $user = User::FindOrFail($id);
            $user->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            echo "success";
        }elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }


}
