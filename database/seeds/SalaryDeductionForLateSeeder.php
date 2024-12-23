<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class SalaryDeductionForLateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('salary_deduction_for_late_attendance')->truncate();
        DB::table('salary_deduction_for_late_attendance')->insert(
            [
                ['for_days' => 3,'day_of_salary_deduction' => 1,'status'=>'Active','created_at'=>$time,'updated_at'=>$time],
            ]

        );
    }
}
