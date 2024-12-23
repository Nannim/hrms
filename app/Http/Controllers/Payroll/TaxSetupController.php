<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\TaxRule;


class TaxSetupController extends Controller
{

    public function index()
    {
        $maleTax     = TaxRule::where('gender','Male')->get();
        $femaleTax   = TaxRule::where('gender','Female')->get();
        return view('admin.payroll.setup.taxSetup',['maleTax'=>$maleTax,'femaleTax'=>$femaleTax]);
    }



    public function updateTaxRule(Request $request)
    {
        $input   = $request->all();
        $data = TaxRule::findOrFail($request->tax_rule_id);

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
           return "success";
        }else {
            return "error";
        }
    }
}
