<?php

use Illuminate\Database\Seeder;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();
        DB::table('modules')->insert(
            [
                ['name' => 'Administration','icon_class' => 'mdi mdi-contacts'],
                ['name' => 'Employee Management','icon_class' => 'mdi mdi-account-multiple-plus'],
                ['name' => 'Leave Management','icon_class' => 'mdi mdi-format-line-weight'],
                ['name' => 'Attendance','icon_class' => 'mdi mdi-clock-fast'],
                ['name' => 'Payroll','icon_class' => 'mdi mdi-cash'],
                ['name' => 'Performance','icon_class' => 'mdi mdi-calculator'],
                ['name' => 'Recruitment','icon_class' => 'mdi mdi-newspaper'],
                ['name' => 'Training','icon_class' => 'mdi mdi-web'],
                ['name' => 'Award','icon_class' => 'mdi mdi-trophy-variant'],
                ['name' => 'Notice Board','icon_class' => 'mdi mdi-flag'],
                ['name' => 'Settings','icon_class' => 'mdi mdi-settings'],
            ]
        );
    }
}
