<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();

        DB::table('user')->truncate();
        DB::table('user')->insert(
            [
                ['role_id' => 1,'user_name' => 'admin','password' => bcrypt('123'), 'remember_token' => str_random(10), 'status' => 1, 'created_by' => 1,'updated_by' => 1,'created_at' => $time, 'updated_at' => $time],
            ]
        );


        DB::table('work_shift')->truncate();
        DB::table('work_shift')->insert(
            [
                ['shift_name' => 'Day','start_time' => '08:30:00', 'end_time' => '17:00:00','late_count_time'=>'08:45:00','created_at' => $time, 'updated_at' => $time],
            ]
        );

//        DB::table('allowance')->truncate();
//        DB::table('allowance')->insert(
//            [
//                ['allowance_name' => 'House Rent','allowance_type' => 'Percentage', 'percentage_of_basic' => 50,'limit_per_month'=>'25000','created_at' => $time, 'updated_at' => $time],
//                ['allowance_name' => 'Car Allowance','allowance_type' => 'Fixed', 'percentage_of_basic' => 0,'limit_per_month'=>'1200','created_at' => $time, 'updated_at' => $time],
//                ['allowance_name' => 'Medical Allowance','allowance_type' => 'Percentage', 'percentage_of_basic' => 10,'limit_per_month'=>'2500','created_at' => $time, 'updated_at' => $time],
//                ['allowance_name' => 'Conveyance','allowance_type' => 'Fixed', 'percentage_of_basic' => 0,'limit_per_month'=>'2500','created_at' => $time, 'updated_at' => $time],
//
//            ]
//        );
//
//        DB::table('deduction')->truncate();
//        DB::table('deduction')->insert(
//            [
//                ['deduction_name' => 'Provident Fund','deduction_type' => 'Percentage', 'percentage_of_basic' => 5,'limit_per_month'=>'0','created_at' => $time, 'updated_at' => $time],
//
//            ]
//        );

        DB::table('pay_grade')->truncate();
        DB::table('pay_grade')->insert(
            [
                ['pay_grade_name' => 'A','gross_salary' => '100000', 'percentage_of_basic' => 50,'basic_salary'=>'50000','overtime_rate'=>500,'created_at' => $time, 'updated_at' => $time],
            ]
        );

//        DB::table('pay_grade_to_allowance')->truncate();
//        DB::table('pay_grade_to_allowance')->insert(
//            [
//                ['pay_grade_id' => 1,'allowance_id' => 1,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 1,'allowance_id' => 2,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 1,'allowance_id' => 3,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 1,'allowance_id' => 4,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 2,'allowance_id' => 1,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 2,'allowance_id' => 2,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 2,'allowance_id' => 3,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 2,'allowance_id' => 4,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 3,'allowance_id' => 1,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 3,'allowance_id' => 3,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 3,'allowance_id' => 4,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 4,'allowance_id' => 1,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 4,'allowance_id' => 3,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 4,'allowance_id' => 4,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 5,'allowance_id' => 1,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 5,'allowance_id' => 3,'created_at' => $time, 'updated_at' => $time],
//                ['pay_grade_id' => 5,'allowance_id' => 4,'created_at' => $time, 'updated_at' => $time],
//            ]
//        );

//        DB::table('pay_grade_to_deduction')->truncate();
//        DB::table('pay_grade_to_deduction')->insert(
//            [
//                ['pay_grade_id' => 1,'deduction_id' => 1,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 2,'deduction_id' => 1,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 3,'deduction_id' => 1,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 4,'deduction_id' => 1,'created_at' => $time, 'updated_at' => $time],
//
//                ['pay_grade_id' => 5,'deduction_id' => 1,'created_at' => $time, 'updated_at' => $time],
//            ]
//        );


        DB::table('employee')->truncate();
        DB::table('employee')->insert(
            [
                ['user_id' => 1,'finger_id' => '1001','department_id' => 1, 'designation_id' => 1, 'work_shift_id' => 1, 'first_name' => "Admin",'pay_grade_id' => 1,'supervisor_id'=>2,
                    'date_of_birth' => "1995-01-01",'date_of_joining' => '2017-01-01', 'gender' => 'Male','phone'=>'1838784536','status'=>1,'created_by' => 1,'updated_by' => 1,'created_at' => $time, 'updated_at' => $time],
            ]
        );

    }
}
