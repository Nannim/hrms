<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Model\FrontSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontSettingController extends Controller
{
    //

    public function index()
    {

        $setting = FrontSetting::orderBy('id', 'desc')->first();
        return view('admin.setting.front.front_setting', ['setting' => $setting]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'company_title'        => 'required',
            'company_logo'         => 'nullable|mimes:jpeg,jpg,png,gif,webp',
            'home_page_big_title'  => 'required',
            'short_description'    => 'required',
            'service_title'        => 'required',
            'job_title'            => 'required',
            'about_us_image'       => 'nullable|mimes:jpeg,jpg,png,gif,webp',
            'footer_text'          => 'required',
            'about_us_description' => 'required',
            'contact_website'      => 'required',
            'contact_phone'        => 'required',
            'contact_email'        => 'required',
            'contact_address'      => 'required',
            'counter_1_title'      => 'required',
            'counter_2_title'      => 'required',
            'counter_3_title'      => 'required',
            'counter_4_title'      => 'required',
            'counter_1_value'      => 'required',
            'counter_2_value'      => 'required',
            'counter_3_value'      => 'required',
            'counter_4_value'      => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try
        {

            $front =  FrontSetting::find($request->id);

            $front->company_title        = $request->company_title;
            $front->home_page_big_title  = $request->home_page_big_title;
            $front->short_description    = $request->short_description;
            $front->service_title        = $request->service_title;
            $front->job_title            = $request->job_title;
            $front->about_us_description = $request->about_us_description;
            $front->contact_website      = $request->contact_website;
            $front->contact_phone        = $request->contact_phone;
            $front->contact_email        = $request->contact_email;
            $front->contact_address      = $request->contact_address;
            $front->counter_1_title      = $request->counter_1_title;
            $front->counter_2_title      = $request->counter_2_title;
            $front->counter_3_title      = $request->counter_3_title;
            $front->counter_4_title      = $request->counter_4_title;
            $front->counter_1_value      = $request->counter_1_value;
            $front->counter_2_value      = $request->counter_2_value;
            $front->counter_3_value      = $request->counter_3_value;
            $front->counter_4_value      = $request->counter_4_value;
            $front->show_job             = $request->show_job;
            $front->show_service         = $request->show_service;
            $front->show_counter         = $request->show_counter;
            $front->show_about           = $request->show_about;
            $front->show_contact         = $request->show_contact;
            $front->footer_text          = $request->footer_text;

            $logo           = $request->file('company_logo');
            $about_us_image = $request->file('about_us_image');

            if ($logo) {
                $name = 'logo' . '.' . $logo->getClientOriginalExtension();
                $logo->move('uploads/front/', $name);
                $front->logo = $name;
            }
            if ($about_us_image) {
                $about_name = 'about_us' . '.' . $about_us_image->getClientOriginalExtension();
                $about_us_image->move('uploads/front/', $about_name);
                $front->about_us_image = $about_name;
            }

            $front->update();

            return redirect()->back()->with('success', 'information updated');

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
