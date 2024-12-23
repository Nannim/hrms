<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class EmployeeAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('employee_attendance')->truncate();
        DB::table('employee_attendance')->insert(
            [
                ['finger_print_id' => '1001','in_out_time'=>'2017-10-10 08:14:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1001','in_out_time'=>'2017-10-10 17:14:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-10-10 09:20:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-10-10 17:30:04','created_at'=>$time,'updated_at'=>$time],

                ['finger_print_id' => '1001','in_out_time'=>'2017-10-11 12:14:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-10-11 08:14:18','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1001','in_out_time'=>'2017-10-12 08:53:27','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-10-12 12:19:05','created_at'=>$time,'updated_at'=>$time],


                ['finger_print_id' => '1001','in_out_time'=>'2017-10-15 09:14:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1001','in_out_time'=>'2017-10-15 17:14:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-10-15 09:30:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-10-15 17:50:04','created_at'=>$time,'updated_at'=>$time],

                ['finger_print_id' => '1001','in_out_time'=>'2017-11-01 09:00:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1001','in_out_time'=>'2017-11-01 17:14:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-11-01 09:30:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-11-01 17:50:04','created_at'=>$time,'updated_at'=>$time],

                ['finger_print_id' => '1001','in_out_time'=>'2017-11-07 09:00:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-11-07 09:10:04','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1003','in_out_time'=>'2017-11-07 09:30:04','created_at'=>$time,'updated_at'=>$time],

                ['finger_print_id' => '1001','in_out_time'=>'2017-11-08 09:00:00','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-11-08 09:05:00','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1003','in_out_time'=>'2017-11-08 09:10:00','created_at'=>$time,'updated_at'=>$time],

                ['finger_print_id' => '1001','in_out_time'=>'2017-11-09 09:00:00','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-11-09 09:10:00','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1003','in_out_time'=>'2017-11-09 09:30:00','created_at'=>$time,'updated_at'=>$time],

                ['finger_print_id' => '1001','in_out_time'=>'2017-11-12 08:45:00','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1002','in_out_time'=>'2017-11-12 09:00:00','created_at'=>$time,'updated_at'=>$time],
                ['finger_print_id' => '1003','in_out_time'=>'2017-11-12 09:20:00','created_at'=>$time,'updated_at'=>$time],

            ]

        );
    }
}
