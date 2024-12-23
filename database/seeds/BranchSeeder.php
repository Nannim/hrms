<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('branch')->truncate();
        DB::table('branch')->insert(
            [
                ['branch_name' => 'Main Branch','created_at'=>$time,'updated_at'=>$time],
                ['branch_name' => 'Dhaka Branch','created_at'=>$time,'updated_at'=>$time],
                ['branch_name' => 'Chittagong Branch','created_at'=>$time,'updated_at'=>$time],

            ]

        );
    }
}
