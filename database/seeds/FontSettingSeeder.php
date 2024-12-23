<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FontSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::insert("INSERT INTO `front_settings` (`id`, `company_title`, `home_page_big_title`, `short_description`,
        `service_title`, `job_title`, `about_us_image`, `logo`, `footer_text`, `about_us_description`, `contact_website`,
         `contact_phone`, `contact_email`, `contact_address`, `counter_1_title`, `counter_1_value`, `counter_2_title`, `counter_2_value`,
          `counter_3_title`, `counter_3_value`, `counter_4_title`, `counter_4_value`, `show_job`, `show_service`, `show_about`, `show_contact`, 
          `show_counter`, `created_at`, `updated_at`) VALUES
       (1, 'Royex', 'Royex - HR and Payroll Management Software',
        'Aenean eros et nisl sagittis as vestibulum at Nullam nulla eros ultricies site amet nonummy id imperdiet feugiat pede as Sed lectuse Donec mollis hendrerit Phasellus at nec sem in at pellentesque facilisis at Praesent congue erat at massa Sed sit cursus turpis vitae tortor that a Donec posuere as vulputate arcu Phasellus accumsan velit.\r\n\r\nMaecenas tempus tellus eget as that condimentum rhoncus sem quam semper libero amete adipiscing sem neque sed ipsum Nam quam nunce blandit at luctus pulvinar hendrerit id lorem Maecenas nec et ante tincidunt tempus.\r\n\r\nSed consequat leo eget bibendum sodales augue at velit cursus nunc.', 'Service We Provide', 'Start Your Career With US', 'about_us.webp', 'logo.png', '© 2020 Royex by BDWEBTRICKS', 'Aenean eros et nisl sagittis as vestibulum at Nullam nulla eros ultricies site amet nonummy id imperdiet feugiat pede as Sed lectuse Donec mollis hendrerit Phasellus at nec sem in at pellentesque facilisis at Praesent congue erat at massa Sed sit cursus turpis vitae tortor that a Donec posuere as vulputate arcu Phasellus accumsan velit.\r\n\r\nMaecenas tempus tellus eget as that condimentum rhoncus sem quam semper libero amete adipiscing sem neque sed ipsum Nam quam nunce blandit at luctus pulvinar hendrerit id lorem Maecenas nec et ante tincidunt tempus.\r\n\r\nSed consequat leo eget bibendum sodales augue at velit cursus nunc.', 'https//:royexbd.com', '0283932949', 'example@gmail.com', 'Royex LTd, 12005 NY', 'Project  Done', 120, 'Content Written', 220, 'Client', 200, 'Training', 230, 1, 1, 1, 1, 1, '2020-09-23 10:43:29', '2020-09-23 11:07:51')");
    }
}
