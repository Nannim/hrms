<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class TaxRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('tax_rule')->truncate();
        DB::table('tax_rule')->insert(
            [
                ['amount' => 250000,'percentage_of_tax'=>0,'amount_of_tax'=>0,'gender'=>'Male','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 400000,'percentage_of_tax'=>10,'amount_of_tax'=>40000,'gender'=>'Male','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 500000,'percentage_of_tax'=>15,'amount_of_tax'=>75000,'gender'=>'Male','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 600000,'percentage_of_tax'=>20,'amount_of_tax'=>120000,'gender'=>'Male','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 3000000,'percentage_of_tax'=>25,'amount_of_tax'=>750000,'gender'=>'Male','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 0,'percentage_of_tax'=>30,'amount_of_tax'=>0,'gender'=>'Male','created_at'=>$time,'updated_at'=>$time],

                ['amount' => 300000,'percentage_of_tax'=>0,'amount_of_tax'=>0,'gender'=>'Female','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 400000,'percentage_of_tax'=>10,'amount_of_tax'=>40000,'gender'=>'Female','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 500000,'percentage_of_tax'=>15,'amount_of_tax'=>75000,'gender'=>'Female','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 600000,'percentage_of_tax'=>20,'amount_of_tax'=>120000,'gender'=>'Female','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 3000000,'percentage_of_tax'=>25,'amount_of_tax'=>750000,'gender'=>'Female','created_at'=>$time,'updated_at'=>$time],
                ['amount' => 0,'percentage_of_tax'=>30,'amount_of_tax'=>0,'gender'=>'Female','created_at'=>$time,'updated_at'=>$time],
            ]

        );
    }
}
