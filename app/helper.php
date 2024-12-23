<?php

use App\Model\FrontSetting;
use Illuminate\Support\Facades\DB;

function dateConvertFormtoDB($date)
{
    if (!empty($date)) {
        return date("Y-m-d", strtotime(str_replace('/', '-', $date)));
    }
}

function dateConvertDBtoForm($date)
{
    if (!empty($date)) {
        $date = strtotime($date);
        return date('d/m/Y', $date);
    }
}

function employeeInfo()
{
    return DB::select("call SP_getEmployeeInfo('" . session('logged_session_data.employee_id') . "')");
}

function permissionCheck()
{

    $role_id       = session('logged_session_data.role_id');
    return $result = json_decode(DB::table('menus')->select('menu_url')
            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
            ->where('menu_permission.role_id', '=', $role_id)
            ->whereNotNull('action')->get()->toJson(), true);

}

function showMenu()
{
    $role_id = session('logged_session_data.role_id');
    $modules = json_decode(DB::table('modules')->get()->toJson(), true);
    $menus   = json_decode(DB::table('menus')
            ->select(DB::raw('menus.id, menus.name, menus.menu_url, menus.parent_id, menus.module_id'))
            ->join('menu_permission', 'menu_permission.menu_id', '=', 'menus.id')
            ->where('menu_permission.role_id', $role_id)
            ->where('menus.status', 1)
            ->whereNull('action')
            ->orderBy('menus.id', 'ASC')
            ->get()->toJson(), true);

    $sideMenu = [];
    if ($menus) {
        foreach ($menus as $menu) {
            if (!isset($sideMenu[$menu['module_id']])) {
                $moduleId = array_search($menu['module_id'], array_column($modules, 'id'));

                $sideMenu[$menu['module_id']]               = [];
                $sideMenu[$menu['module_id']]['id']         = $modules[$moduleId]['id'];
                $sideMenu[$menu['module_id']]['name']       = $modules[$moduleId]['name'];
                $sideMenu[$menu['module_id']]['icon_class'] = $modules[$moduleId]['icon_class'];
                $sideMenu[$menu['module_id']]['menu_url']   = '#';
                $sideMenu[$menu['module_id']]['parent_id']  = '';
                $sideMenu[$menu['module_id']]['module_id']  = $modules[$moduleId]['id'];
                $sideMenu[$menu['module_id']]['sub_menu']   = [];
            }
            if ($menu['parent_id'] == 0) {
                $sideMenu[$menu['module_id']]['sub_menu'][$menu['id']]             = $menu;
                $sideMenu[$menu['module_id']]['sub_menu'][$menu['id']]['sub_menu'] = [];
            } else {
                array_push($sideMenu[$menu['module_id']]['sub_menu'][$menu['parent_id']]['sub_menu'], $menu);
            }

        }
    }

    return $sideMenu;
}

function convartMonthAndYearToWord($data)
{
    $monthAndYear = explode('-', $data);

    $month     = $monthAndYear[1];
    $dateObj   = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    $year      = $monthAndYear[0];

    return $monthAndYearName = $monthName . " " . $year;
}

function employeeAward()
{
    return ['Employee of the Month' => 'Employee of the Month', 'Employee of the Year' => 'Employee of the Year', 'Best Employee' => 'Best Employee'];
}

function findMonthToAllDate($month)
{
    $start_date = $month . '-01';
    $end_date   = date("Y-m-t", strtotime($start_date));

    $target      = strtotime($start_date);
    $workingDate = [];
    while ($target <= strtotime(date("Y-m-d", strtotime($end_date)))) {
        $temp             = [];
        $temp['date']     = date('Y-m-d', $target);
        $temp['day']      = date('d', $target);
        $temp['day_name'] = date('D', $target);
        $workingDate[]    = $temp;
        $target += (60 * 60 * 24);
    }
    return $workingDate;
}

function findMonthToStartDateAndEndDate($month)
{
    $start_date = $month . '-01';
    $end_date   = date("Y-m-t", strtotime($start_date));
    $data       = [
        'start_date' => $start_date,
        'end_date'   => $end_date,
    ];
    return $data;
}

function getFrontData()
{
    $setting = FrontSetting::orderBy('id', 'desc')->first();

    return $setting;
}
