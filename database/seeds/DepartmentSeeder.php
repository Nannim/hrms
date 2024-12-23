<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('department')->truncate();
        DB::table('department')->insert(
            [
                ['department_name' => 'HR','created_at'=>$time,'updated_at'=>$time],

            ]

        );
    }
}
