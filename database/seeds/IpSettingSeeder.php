<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IpSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::insert("INSERT INTO `ip_settings` (`id`, `ip_address`, `ip_status`, `status`, `created_at`, `updated_at`) VALUES
        (1, '127.0.0.1', 0, 1, NULL, '2020-07-19 04:32:30')");
    }
}
