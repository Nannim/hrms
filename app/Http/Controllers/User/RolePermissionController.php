<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\RolePermissionRequest;

use App\Repositories\CommonRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use function MongoDB\BSON\toJSON;

use Illuminate\Http\Request;


class RolePermissionController extends Controller
{

    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }


    public function index()
    {
        $roleList = $this->commonRepository->roleList();
        return view('admin.user.role.add_user_permission', ['data' => $roleList]);
    }



    public function getAllMenu(Request $request)
    {
        $role_id     = $request->role_id;
        $permissions =  json_decode(DB::table('menus')
                        ->select(DB::raw('`menus`.`id`, `menus`.`name`, `menus`.`menu_url`, `menus`.`parent_id`, `menus`.`module_id`,menu_permission.menu_id'))
                        ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
                        ->where('menu_permission.role_id', '=', $role_id)
                        ->get()->toJson(),true);


        $allMenus = json_decode(DB::table('menus')
                    ->select(DB::raw('menus.*,modules.name as moduleName,modules.icon_class'))
                    ->join('modules', 'modules.id', '=', 'menus.module_id')
                    ->where('menus.status', '=', 1)
                    ->whereNotNull('menu_url')
                    ->orderBy('module_id')
                    ->get()->toJSON(),true);

        $subMenu = [];

        $arrayFormat = [];
        foreach ($allMenus as $allMenu)
        {
            $hasPermission = array_search($allMenu['id'], array_column($permissions, 'menu_id'));

            if(gettype($hasPermission) == 'integer'){
                $allMenu['hasPermission'] ='yes';
            }else{
                $allMenu['hasPermission'] ='no';
            }

            if(!empty($allMenu['action'])){
                $subMenu[$allMenu['parent_id']][] = $allMenu;
            }

            if($allMenu['action']==''){
                $arrayFormat[$allMenu['moduleName']][$allMenu['name']] = $allMenu;
            }
        }

        return ['arrayFormat'=>$arrayFormat,'subMenu'=>$subMenu];
    }



    public function store(RolePermissionRequest $request)
    {

        try{
            DB::beginTransaction();

                $role_id    =  $request->role_id;
                DB::table('menu_permission')->where('role_id', '=', $role_id)->delete();
                $menu       = count($request->menu_id);

                if($menu == 0)
                {
                    DB::commit();
                    return redirect()->back()->with('success', 'Role permission update successfully');
                }

                for ($i = 0; $i < $menu; $i++)
                {
                    $getParentId = DB::table('menus')->where('id','=',$request->menu_id[$i])->first();
                    if($getParentId->parent_id !=0)
                    {
                        $checkParentMenuDuplicate = DB::table('menu_permission')->where('role_id',$role_id)->where('menu_id',$getParentId->parent_id)->first();
                        if(!$checkParentMenuDuplicate)
                        {
                            $insertParentMenu = array(
                                "menu_id" => $getParentId->parent_id,
                                "role_id" => $role_id,
                            );
                            DB::table('menu_permission')->insert($insertParentMenu);
                        }
                    }
                    $insertMenu = array(
                        "menu_id" => $request->menu_id[$i],
                        "role_id" => $role_id,
                    );
                    DB::table('menu_permission')->insert($insertMenu);
                }

            DB::commit();
            $bug = 0;
        }
        catch(\Exception $e){
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Role Permission Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }

    }



}
