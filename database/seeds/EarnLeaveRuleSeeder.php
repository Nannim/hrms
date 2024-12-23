<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class EarnLeaveRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('earn_leave_rule')->truncate();
        DB::table('earn_leave_rule')->insert(
            [
                ['for_month' => '1','day_of_earn_leave'=>'1','created_at'=>$time,'updated_at'=>$time],
            ]

        );
    }
}
