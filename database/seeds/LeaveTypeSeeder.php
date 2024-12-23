<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('leave_type')->truncate();
        DB::table('leave_type')->insert(
            [
                ['leave_type_name' => 'Earn Leave','num_of_day'=>'0','created_at'=>$time,'updated_at'=>$time],
                ['leave_type_name' => 'Casual Leave','num_of_day'=>'22','created_at'=>$time,'updated_at'=>$time],
                ['leave_type_name' => 'Sick Leave	','num_of_day'=>'20','created_at'=>$time,'updated_at'=>$time],
            ]
        );
    }
}
