<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Model\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Services::orderBy('service_name', 'ASC')->get();
        return view('admin.setting.services.services', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.setting.services.create_service');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'service_icon' => 'required|mimes:jpeg,jpg,png,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try
        {

            $service = new Services;

            $service->service_name = $request->service_name;

            $image = $request->file('service_icon');

            if ($image) {
                $image_name = time() . '.' . $image->getClientOriginalExtension();

                $image->move('uploads/services/', $image_name);
                $service->service_icon = $image_name;
            }

            $service->status = 1;
            $service->save();

            return redirect('service')->with('success', 'Service Added');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $services = Services::find($id);
        return view('admin.setting.services.edit_service', ['service' => $services]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required',
            'service_icon' => 'nullable|mimes:jpeg,jpg,png,gif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try
        {
            $services = Services::find($id);
            $services->service_name = $request->service_name;

            $image = $request->file('service_icon');

            if ($image) {
                if (file_exists('uploads/services/' . $services->service_icon) && !empty($services->service_icon)) {
                    unlink('uploads/services/' . $services->service_icon);
                }

                $image_name = time() . '.' . $image->getClientOriginalExtension();

                $image->move('uploads/services/', $image_name);
                $services->service_icon = $image_name;
            }

            $services->status = 1;
            $services->save();

            return redirect('service')->with('success', 'Service Updated');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $services = Services::find($id);
            if (file_exists('uploads/services/' . $services->service_icon) && !empty($services->service_icon)) {
                unlink('uploads/services/' . $services->service_icon);
            }
            $services->delete();
            DB::commit();
            $bug = 0;

        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }

    }
}
