<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Lib\Enumerations\LeaveStatus;
use App\Model\Branch;
use App\Model\CompanyAddressSetting;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\LeaveApplication;
use App\Model\PrintHeadSetting;
use App\Model\SalaryDetails;
use App\Model\SalaryDetailsToAllowance;
use App\Model\SalaryDetailsToDeduction;
use App\Model\SalaryDetailsToLeave;
use App\Repositories\CommonRepository;
use App\Repositories\PayrollRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenerateSalarySheet extends Controller
{

    protected $commonRepository;
    protected $payrollRepository;

    public function __construct(CommonRepository $commonRepository, PayrollRepository $payrollRepository)
    {
        $this->commonRepository  = $commonRepository;
        $this->payrollRepository = $payrollRepository;
    }

    public function index(Request $request)
    {
        $results = SalaryDetails::with(['employee' => function ($query) {
            $query->with(['department', 'designation', 'branch', 'payGrade', 'hourlySalaries']);
        }])->orderBy('salary_details_id', 'DESC')->paginate(10);
        if (request()->ajax()) {

            $results = SalaryDetails::with(['employee' => function ($query) {
                $query->with(['department', 'payGrade', 'hourlySalaries']);
            }])->orderBy('salary_details_id', 'DESC');

            if ($request->monthField != '') {
                $results->where('month_of_salary', $request->monthField);
            }

            if ($request->status != '') {
                $results->where('status', $request->status);
            }

            $results = $results->paginate(10);

            return View('admin.payroll.salarySheet.pagination', compact('results'))->render();
        }
        $departmentList = $this->commonRepository->departmentList();
        return view('admin.payroll.salarySheet.salaryDetails', ['results' => $results, 'departmentList' => $departmentList]);
    }

    public function monthSalary(Request $request)
    {
        $results = SalaryDetails::with(['employee' => function ($query) {
            $query->with('payGrade');
        }])->where('month_of_salary', $request->month)->get();

        return view('admin.payroll.salarySheet.salaryDetails', ['results' => $results]);
    }

    public function bulkSalary()
    {

        $departments  = Department::get();
        $branches     = Branch::get();
        $designations = Designation::get();

        return view('admin.payroll.salarySheet.generateBulkSalarySheet', [
            'departments'  => $departments,
            'branches'     => $branches,
            'designations' => $designations,
        ]);

        //   get to the bulk salary page
    }

    public function generateBulkSalary(Request $request)
    {

        $month        = $request->month;
        $from_date    = $month . '-01';
        $to_date      = date('Y-m-t', strtotime($from_date));
        $BulkEmployee = Employee::with('payGrade', 'hourlySalaries', 'department', 'designation');

        if ($request->branch_id != '') {
            $BulkEmployee->where('branch_id', '=', $request->branch_id);
        }
        if ($request->designation_id != '') {
            $BulkEmployee->where('designation_id', '=', $request->designation_id);
        }
        if ($request->department_id != '') {
            $BulkEmployee->where('department_id', '=', $request->department_id);
        }

        $BulkEmployee = $BulkEmployee->get();

        if (count($BulkEmployee) <= 0) {
            return redirect('generateSalarySheet')->with('error', 'No Employee Found.');
        }

        try {
            DB::beginTransaction();
            $done = 0;
            foreach ($BulkEmployee as $employeeDetails) {

                $query = DB::select("SELECT temp.* FROM (
                SELECT DATE_FORMAT(date,'%Y-%m') AS yearAndMonth,view_employee_in_out_data.finger_print_id,employee.employee_id FROM view_employee_in_out_data
                JOIN employee ON employee.finger_id = view_employee_in_out_data.finger_print_id
                ) AS temp WHERE yearAndMonth='$month' AND employee_id = $employeeDetails->employee_id");

                if (count($query) <= 0) {
                    continue;
                }

                $queryResult = SalaryDetails::where('employee_id', $employeeDetails->employee_id)->where('month_of_salary', $month)->count();
                if ($queryResult > 0) {
                    continue;
                }
                if (!empty($employeeDetails->pay_grade_id) || $employeeDetails->pay_grade_id != 0) {
                    $employeeAllInfo = [];
                    $allowance       = [];
                    $deduction       = [];
                    $tax             = 0;

                    $leaveRecord = LeaveApplication::select('leave_type.leave_type_id', 'leave_type_name', 'number_of_day', 'application_from_date', 'application_to_date')
                        ->join('leave_type', 'leave_type.leave_type_id', 'leave_application.leave_type_id')
                        ->where('status', LeaveStatus::$APPROVE)
                        ->where('application_from_date', '>=', $from_date)
                        ->where('application_to_date', '<=', $to_date)
                        ->where('employee_id', $employeeDetails->employee_id)
                        ->get();

                    $monthAndYear = explode('-', $month);
                    $start_year   = $monthAndYear[0] . '-01';
                    $end_year     = $monthAndYear[0] . '-12';

                    $financialYearTax = SalaryDetails::select(DB::raw('SUM(tax) as totalTax'))
                        ->where('status', 1)
                        ->where('employee_id', $employeeDetails->employee_id)
                        ->whereBetween('month_of_salary', [$start_year, $end_year])
                        ->first();

                    $allowance = $this->payrollRepository->calculateEmployeeAllowance($employeeDetails->payGrade->basic_salary, $employeeDetails->pay_grade_id);

                    $deduction = $this->payrollRepository->calculateEmployeeDeduction($employeeDetails->payGrade->basic_salary, $employeeDetails->pay_grade_id);
                    $tax       = $this->payrollRepository->calculateEmployeeTax(
                        $employeeDetails->payGrade->gross_salary,
                        $employeeDetails->payGrade->basic_salary,
                        $employeeDetails->date_of_birth,
                        $employeeDetails->gender,
                        $employeeDetails->pay_grade_id
                    );
                    $employeeAllInfo = $this->payrollRepository->getEmployeeOtmAbsLvLtAndWokDays(
                        $employeeDetails->employee_id, $month,
                        $employeeDetails->payGrade->overtime_rate,
                        $employeeDetails->payGrade->basic_salary
                    );

                    $data = [
                        'allowances'          => $allowance,
                        'deductions'          => $deduction,
                        'tax'                 => $tax['monthlyTax'],
                        'taxAbleSalary'       => $tax['taxAbleSalary'],
                        'employee_id'         => $employeeDetails->employee_id,
                        'month'               => $month,
                        'employeeAllInfo'     => $employeeAllInfo,
                        'employeeDetails'     => $employeeDetails,
                        'leaveRecords'        => $leaveRecord,
                        'financialYearTax'    => $financialYearTax,
                        'employeeGrossSalary' => $employeeDetails->payGrade->gross_salary,
                    ];

                    $input = $this->payrollRepository->makeMonthlyBulkDataFormat($data);
                    $done += 1;

                } else {

                    // hourly salary
                    $employeeHourlySalary = $this->payrollRepository->getEmployeeHourlySalary($employeeDetails->employee_id, $month, $employeeDetails->hourlySalaries->hourly_rate);

                    $hourlyData = [
                        'hourly_rate'      => $employeeDetails->hourlySalaries->hourly_rate,
                        'employee_id'      => $employeeDetails->employee_id,
                        'month'            => $month,
                        'totalWorkingHour' => $employeeHourlySalary['totalWorkingHour'],
                        'totalSalary'      => $employeeHourlySalary['totalSalary'],
                        'employeeDetails'  => $employeeDetails,
                    ];

                    $input = $this->payrollRepository->makeHourlyBulkDataFormat($hourlyData);
                    $done += 1;

                }

                // insert all

                $input['created_by'] = Auth::user()->user_id;
                $input['updated_by'] = Auth::user()->user_id;

                $parentData                       = SalaryDetails::create($input);
                $employeeSalaryDetailsToAllowance = $this->makeEmployeeSalaryDetailsToAllowanceDataFormat($input, $parentData->salary_details_id);

                if (count($employeeSalaryDetailsToAllowance) > 0) {
                    SalaryDetailsToAllowance::insert($employeeSalaryDetailsToAllowance);
                }

                $employeeSalaryDetailsToDeduction = $this->makeEmployeeSalaryDetailsToDeductionDataFormat($input, $parentData->salary_details_id);
                if (count($employeeSalaryDetailsToDeduction) > 0) {
                    SalaryDetailsToDeduction::insert($employeeSalaryDetailsToDeduction);
                }

                $employeeSalaryDetailsToLeave = $this->makeEmployeeSalaryDetailsToLeaveDataFormat($input, $parentData->salary_details_id);
                if (count($employeeSalaryDetailsToLeave) > 0) {
                    SalaryDetailsToLeave::insert($employeeSalaryDetailsToLeave);
                }

            }
            DB::commit();

            if ($done == 0) {
                return redirect('generateSalarySheet')->with('error', 'No Related Data Found.');
            }
            return redirect('generateSalarySheet')->with('success', 'Salary Generate successfully.');
        } catch (\Exception $e) {

            DB::rollback();

            return redirect('generateSalarySheet')->with('error', $e->getMessage());

        }
    }

    public function create()
    {
        $employeeList = $this->commonRepository->employeeList();
        return view('admin.payroll.salarySheet.generateSalarySheet', ['employeeList' => $employeeList]);
    }

    public function calculateEmployeeSalary(Request $request)
    {

        $query = DB::select("SELECT temp.* FROM (
                    SELECT DATE_FORMAT(date,'%Y-%m') AS yearAndMonth,view_employee_in_out_data.finger_print_id,employee.employee_id FROM view_employee_in_out_data
                    JOIN employee ON employee.finger_id = view_employee_in_out_data.finger_print_id
                    ) AS temp WHERE yearAndMonth='$request->month' AND employee_id = $request->employee_id");

        if (count($query) <= 0) {
            return redirect('generateSalarySheet/create')->with('error', 'No attendance found.');
        }

        $queryResult = SalaryDetails::where('employee_id', $request->employee_id)->where('month_of_salary', $request->month)->count();
        if ($queryResult > 0) {
            return redirect('generateSalarySheet')->with('error', 'Salary already generated for this month.');
        }

        $employeeList    = $this->commonRepository->employeeList();
        $employeeDetails = Employee::with('payGrade', 'hourlySalaries', 'department', 'designation')->where('employee_id', $request->employee_id)->first();
        if ($employeeDetails->pay_grade_id != 0) {
            $employeeAllInfo = [];
            $allowance       = [];
            $deduction       = [];
            $tax             = 0;

            $from_date = $request->month . "-01";
            $to_date   = date('Y-m-t', strtotime($from_date));

            $leaveRecord = LeaveApplication::select('leave_type.leave_type_id', 'leave_type_name', 'number_of_day', 'application_from_date', 'application_to_date')
                ->join('leave_type', 'leave_type.leave_type_id', 'leave_application.leave_type_id')
                ->where('status', LeaveStatus::$APPROVE)
                ->where('application_from_date', '>=', $from_date)
                ->where('application_to_date', '<=', $to_date)
                ->where('employee_id', $request->employee_id)
                ->get();

            $monthAndYear = explode('-', $request->month);
            $start_year   = $monthAndYear[0] . '-01';
            $end_year     = $monthAndYear[0] . '-12';

            $financialYearTax = SalaryDetails::select(DB::raw('SUM(tax) as totalTax'))
                ->where('status', 1)
                ->where('employee_id', $request->employee_id)
                ->whereBetween('month_of_salary', [$start_year, $end_year])
                ->first();

            $allowance = $this->payrollRepository->calculateEmployeeAllowance($employeeDetails->payGrade->basic_salary, $employeeDetails->pay_grade_id);

            $deduction = $this->payrollRepository->calculateEmployeeDeduction($employeeDetails->payGrade->basic_salary, $employeeDetails->pay_grade_id);
            $tax       = $this->payrollRepository->calculateEmployeeTax(
                $employeeDetails->payGrade->gross_salary,
                $employeeDetails->payGrade->basic_salary,
                $employeeDetails->date_of_birth,
                $employeeDetails->gender,
                $employeeDetails->pay_grade_id
            );
            $employeeAllInfo = $this->payrollRepository->getEmployeeOtmAbsLvLtAndWokDays(
                $request->employee_id, $request->month,
                $employeeDetails->payGrade->overtime_rate,
                $employeeDetails->payGrade->basic_salary
            );

            $data = [
                'employeeList'        => $employeeList,
                'allowances'          => $allowance,
                'deductions'          => $deduction,
                'tax'                 => $tax['monthlyTax'],
                'taxAbleSalary'       => $tax['taxAbleSalary'],
                'employee_id'         => $request->employee_id,
                'month'               => $request->month,
                'employeeAllInfo'     => $employeeAllInfo,
                'employeeDetails'     => $employeeDetails,
                'leaveRecords'        => $leaveRecord,
                'financialYearTax'    => $financialYearTax,
                'employeeGrossSalary' => $employeeDetails->payGrade->gross_salary,
            ];
        } else {
            $employeeHourlySalary = $this->payrollRepository->getEmployeeHourlySalary($request->employee_id, $request->month, $employeeDetails->hourlySalaries->hourly_rate);

            $data = [
                'employeeList'     => $employeeList,
                'hourly_rate'      => $employeeDetails->hourlySalaries->hourly_rate,
                'employee_id'      => $request->employee_id,
                'month'            => $request->month,
                'totalWorkingHour' => $employeeHourlySalary['totalWorkingHour'],
                'totalSalary'      => $employeeHourlySalary['totalSalary'],
                'employeeDetails'  => $employeeDetails,

            ];

            return view('admin.payroll.salarySheet.generateHourlySalarySheet', $data);
        }
        return view('admin.payroll.salarySheet.generateSalarySheet', $data);
    }

    public function store(Request $request)
    {
        $input               = $request->all();
        $input['created_by'] = Auth::user()->user_id;
        $input['updated_by'] = Auth::user()->user_id;

        try {
            DB::beginTransaction();

            $parentData                       = SalaryDetails::create($input);
            $employeeSalaryDetailsToAllowance = $this->makeEmployeeSalaryDetailsToAllowanceDataFormat($request->all(), $parentData->salary_details_id);

            if (count($employeeSalaryDetailsToAllowance) > 0) {
                SalaryDetailsToAllowance::insert($employeeSalaryDetailsToAllowance);
            }

            $employeeSalaryDetailsToDeduction = $this->makeEmployeeSalaryDetailsToDeductionDataFormat($request->all(), $parentData->salary_details_id);
            if (count($employeeSalaryDetailsToDeduction) > 0) {
                SalaryDetailsToDeduction::insert($employeeSalaryDetailsToDeduction);
            }

            $employeeSalaryDetailsToLeave = $this->makeEmployeeSalaryDetailsToLeaveDataFormat($request->all(), $parentData->salary_details_id);
            if (count($employeeSalaryDetailsToLeave) > 0) {
                SalaryDetailsToLeave::insert($employeeSalaryDetailsToLeave);
            }

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect('generateSalarySheet')->with('success', 'Salary Generate successfully.');
        } else {
            return redirect('generateSalarySheet')->with('error', 'Something Error Found !, Please try again.');
        }

    }

    public function makeEmployeeSalaryDetailsToAllowanceDataFormat($data, $salary_details_id)
    {
        $allowanceData = [];
        if (isset($data['allowance_id'])) {
            for ($i = 0; $i < count($data['allowance_id']); $i++) {
                $allowanceData[$i] = [
                    'salary_details_id'   => $salary_details_id,
                    'allowance_id'        => $data['allowance_id'][$i],
                    'amount_of_allowance' => $data['amount_of_allowance'][$i],
                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                ];
            }
        }
        return $allowanceData;
    }

    public function makeEmployeeSalaryDetailsToDeductionDataFormat($data, $salary_details_id)
    {
        $deductionData = [];
        if (isset($data['deduction_id'])) {
            for ($i = 0; $i < count($data['deduction_id']); $i++) {
                $deductionData[$i] = [
                    'salary_details_id'   => $salary_details_id,
                    'deduction_id'        => $data['deduction_id'][$i],
                    'amount_of_deduction' => $data['amount_of_deduction'][$i],
                    'created_at'          => Carbon::now(),
                    'updated_at'          => Carbon::now(),
                ];
            }
        }
        return $deductionData;
    }

    public function makeEmployeeSalaryDetailsToLeaveDataFormat($data, $salary_details_id)
    {
        $leaveData = [];
        if (isset($data['num_of_day'])) {
            for ($i = 0; $i < count($data['num_of_day']); $i++) {
                $leaveData[$i] = [
                    'salary_details_id' => $salary_details_id,
                    'num_of_day'        => $data['num_of_day'][$i],
                    'leave_type_id'     => $data['leave_type_id'][$i],
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),
                ];
            }
        }
        return $leaveData;
    }

    public function makePayment(Request $request)
    {
        $data['status']         = 1;
        $data['comment']        = $request->comment;
        $data['payment_method'] = $request->payment_method;
        $data['created_by']     = Auth::user()->user_id;
        $data['updated_by']     = Auth::user()->user_id;
        $data['created_at']     = Carbon::now();
        $data['updated_at']     = Carbon::now();
        try {
            SalaryDetails::where('salary_details_id', $request->salary_details_id)->update($data);
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } else {
            echo "error";
        }
    }

    public function generatePayslip($id)
    {
        $paySlipId = $id;
        $ifHourly  = SalaryDetails::with(['employee' => function ($q) {
            $q->with(['hourlySalaries', 'department', 'designation']);
        }])->where('salary_details_id', $paySlipId)->first();

        if ($ifHourly->action == 'monthlySalary') {
            $paySlipDataFormat = $this->paySlipDataFormat($paySlipId);
        } else {
            $companyAddress = CompanyAddressSetting::first();
            $data           = [
                'salaryDetails'  => $ifHourly,
                'companyAddress' => $companyAddress,
                'paySlipId'      => $id,
            ];
            return view('admin.payroll.salarySheet.hourlyPaySlip', $data);
        }

        return view('admin.payroll.salarySheet.monthlyPaySlip', $paySlipDataFormat);
    }

    public function paySlipDataFormat($id)
    {
        $printHeadSetting = PrintHeadSetting::first();
        $salaryDetails    = SalaryDetails::select('salary_details.*', 'employee.employee_id', 'employee.department_id', 'employee.designation_id', 'department.department_name', 'designation.designation_name', 'employee.first_name', 'employee.last_name', 'pay_grade.pay_grade_name', 'employee.date_of_joining')
            ->join('employee', 'employee.employee_id', 'salary_details.employee_id')
            ->join('department', 'department.department_id', 'employee.department_id')
            ->join('designation', 'designation.designation_id', 'employee.designation_id')
            ->join('pay_grade', 'pay_grade.pay_grade_id', 'employee.pay_grade_id')
            ->where('salary_details_id', $id)->first();

        $salaryDetailsToAllowance = SalaryDetailsToAllowance::join('allowance', 'allowance.allowance_id', 'salary_details_to_allowance.allowance_id')
            ->where('salary_details_id', $id)->get();

        $salaryDetailsToDeduction = SalaryDetailsToDeduction::join('deduction', 'deduction.deduction_id', 'salary_details_to_deduction.deduction_id')
            ->where('salary_details_id', $id)->get();

        $salaryDetailsToLeave = SalaryDetailsToLeave::select('salary_details_to_leave.*', 'leave_type.leave_type_name')
            ->join('leave_type', 'leave_type.leave_type_id', 'salary_details_to_leave.leave_type_id')
            ->where('salary_details_id', $id)->get();

        $monthAndYear = explode('-', $salaryDetails->month_of_salary);
        $start_year   = $monthAndYear[0] . '-01';
        $end_year     = $salaryDetails->month_of_salary;

        $financialYearTax = SalaryDetails::select(DB::raw('SUM(tax) as totalTax'))
            ->where('status', 1)
            ->where('employee_id', $salaryDetails->employee_id)
            ->whereBetween('month_of_salary', [$start_year, $end_year])
            ->first();

        return $data = [
            'salaryDetails'            => $salaryDetails,
            'salaryDetailsToAllowance' => $salaryDetailsToAllowance,
            'salaryDetailsToDeduction' => $salaryDetailsToDeduction,
            'paySlipId'                => $id,
            'financialYearTax'         => $financialYearTax,
            'salaryDetailsToLeave'     => $salaryDetailsToLeave,
            'printHeadSetting'         => $printHeadSetting,
        ];
    }

    public function downloadPayslip($id)
    {
        $payslipId = $id;
        $ifHourly  = SalaryDetails::with(['employee' => function ($q) {
            $q->with(['hourlySalaries', 'department', 'designation']);
        }])->where('salary_details_id', $payslipId)->first();

        if ($ifHourly->action == 'monthlySalary') {
            $result = $this->paySlipDataFormat($payslipId);
        } else {
            $printHeadSetting = PrintHeadSetting::first();
            $data             = [
                'salaryDetails'    => $ifHourly,
                'printHeadSetting' => $printHeadSetting,
            ];
//          return view('admin.payroll.salarySheet.hourlyPaySlipPdf',$data);
            $pdf = PDF::loadView('admin.payroll.salarySheet.hourlyPaySlipPdf', $data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download("payslip.pdf");
        }

        $pdf = PDF::loadView('admin.payroll.salarySheet.monthlyPaySlipPdf', $result);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("payslip.pdf");
    }

    public function downloadMyPayroll()
    {
        $printHeadSetting = PrintHeadSetting::first();
        $results          = SalaryDetails::with(['employee' => function ($query) {
            $query->with('payGrade');
        }])->where('status', 1)->where('employee_id', session('logged_session_data.employee_id'))->orderBy('salary_details_id', 'DESC')->get();

        $data = [
            'printHead' => $printHeadSetting,
            'results'   => $results,
        ];

        $pdf = PDF::loadView('admin.payroll.report.pdf.myPayrollPdf', $data);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download("my-payroll-Pdf.pdf");

    }

    public function paymentHistory(Request $request)
    {
        $results = '';
        if ($request->month) {
            $results = SalaryDetails::select('salary_details.basic_salary', 'salary_details.gross_salary', 'salary_details.month_of_salary', DB::raw('CONCAT(COALESCE(employee.first_name,\'\'),\' \',COALESCE(employee.last_name,\'\')) AS fullName'),
                'employee.photo', 'pay_grade.pay_grade_name', 'hourly_salaries.hourly_grade', 'department.department_name')
                ->join('employee', 'employee.employee_id', 'salary_details.employee_id')
                ->join('department', 'department.department_id', 'employee.department_id')
                ->leftJoin('pay_grade', 'pay_grade.pay_grade_id', 'employee.pay_grade_id')
                ->leftJoin('hourly_salaries', 'hourly_salaries.hourly_salaries_id', 'employee.hourly_salaries_id')
                ->where('salary_details.status', 1)
                ->where('salary_details.month_of_salary', $request->month)
                ->orderBy('salary_details_id', 'DESC')
                ->get();
        }

        return view('admin.payroll.report.paymentHistory', ['results' => $results, 'month' => $request->month]);
    }

    public function myPayroll()
    {
        $results = SalaryDetails::with(['employee' => function ($query) {
            $query->with('payGrade');
        }])->where('status', 1)->where('employee_id', session('logged_session_data.employee_id'))->orderBy('salary_details_id', 'DESC')->get();
        return view('admin.payroll.report.myPayroll', ['results' => $results]);
    }

}
