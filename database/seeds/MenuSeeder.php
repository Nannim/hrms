<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        DB::insert("INSERT INTO `menus` (`id`, `parent_id`, `action`, `name`, `menu_url`, `module_id`, `status`) VALUES
        (1, 0, NULL, 'User', 'user.index', 1, 2),
        (2, 0, NULL, 'Manage Role', NULL, 1, 1),
        (3, 2, NULL, 'Add Role', 'userRole.index', 1, 1),
        (4, 2, NULL, 'Add Role Permission', 'rolePermission.index', 1, 1),
        (5, 0, NULL, 'Change Password', 'changePassword.index', 1, 1),
        (6, 0, NULL, 'Department', 'department.index', 2, 1),
        (7, 0, NULL, 'Designation', 'designation.index', 2, 1),
        (8, 0, NULL, 'Branch', 'branch.index', 2, 1),
        (9, 0, NULL, 'Manage Employee', 'employee.index', 2, 1),
        (10, 0, NULL, 'Setup', NULL, 3, 1),
        (11, 10, NULL, 'Manage Holiday', 'holiday.index', 3, 1),
        (12, 10, NULL, 'Public Holiday', 'publicHoliday.index', 3, 1),
        (13, 10, NULL, 'Weekly Holiday', 'weeklyHoliday.index', 3, 1),
        (14, 10, NULL, 'Leave Type', 'leaveType.index', 3, 1),
        (15, 0, NULL, 'Leave Application', NULL, 3, 1),
        (16, 15, NULL, 'Apply for Leave', 'applyForLeave.index', 3, 1),
        (17, 15, NULL, 'Requested Application', 'requestedApplication.index', 3, 1),
        (18, 0, NULL, 'Setup', NULL, 4, 1),
        (19, 18, NULL, 'Manage Work Shift', 'workShift.index', 4, 1),
        (20, 0, NULL, 'Report', NULL, 4, 1),
        (21, 20, NULL, 'Daily Attendance', 'dailyAttendance.dailyAttendance', 4, 1),
        (22, 0, NULL, 'Report', NULL, 3, 1),
        (23, 22, NULL, 'Leave Report', 'leaveReport.leaveReport', 3, 1),
        (24, 20, NULL, 'Monthly Attendance', 'monthlyAttendance.monthlyAttendance', 4, 1),
        (25, 0, NULL, 'Setup', NULL, 5, 1),
        (26, 25, NULL, 'Tax Rule Setup', 'taxSetup.index', 5, 1),
        (27, 0, NULL, 'Allowance', 'allowance.index', 5, 1),
        (28, 0, NULL, 'Deduction', 'deduction.index', 5, 1),
        (29, 0, NULL, 'Monthly Pay Grade', 'payGrade.index', 5, 1),
        (30, 0, NULL, 'Hourly Pay Grade', 'hourlyWages.index', 5, 1),
        (31, 0, NULL, 'Generate Salary Sheet', 'generateSalarySheet.index', 5, 1),
        (32, 25, NULL, 'Late Configration', 'salaryDeductionRule.index', 5, 1),
        (33, 0, NULL, 'Report', NULL, 5, 1),
        (34, 33, NULL, 'Payment History', 'paymentHistory.paymentHistory', 5, 1),
        (35, 33, NULL, 'My Payroll', 'myPayroll.myPayroll', 5, 1),
        (36, 0, NULL, 'Performance Category', 'performanceCategory.index', 6, 1),
        (37, 0, NULL, 'Performance Criteria', 'performanceCriteria.index', 6, 1),
        (38, 0, NULL, 'Employee Performance', 'employeePerformance.index', 6, 1),
        (39, 0, NULL, 'Report', NULL, 6, 1),
        (40, 39, NULL, 'Summary Report', 'performanceSummaryReport.performanceSummaryReport', 6, 1),
        (41, 0, NULL, 'Job Post', 'jobPost.index', 7, 1),
        (42, 0, NULL, 'Job Candidate', 'jobCandidate.index', 7, 1),
        (43, 20, NULL, 'My Attendance Report', 'myAttendanceReport.myAttendanceReport', 4, 1),
        (44, 10, NULL, 'Earn Leave Configure', 'earnLeaveConfigure.index', 3, 1),
        (45, 0, NULL, 'Training Type', 'trainingType.index', 8, 1),
        (46, 0, NULL, 'Training List', 'trainingInfo.index', 8, 1),
        (47, 0, NULL, 'Training Report', 'employeeTrainingReport.employeeTrainingReport', 8, 1),
        (48, 0, NULL, 'Award', 'award.index', 9, 1),
        (49, 0, NULL, 'Notice', 'notice.index', 10, 1),
        (50, 0, NULL, 'Settings', 'generalSettings.index', 11, 1),
        (51, 0, NULL, 'Manual Attendance', 'manualAttendance.manualAttendance', 4, 1),
        (52, 22, NULL, 'Summary Report', 'summaryReport.summaryReport', 3, 1),
        (53, 22, NULL, 'My Leave Report', 'myLeaveReport.myLeaveReport', 3, 1),
        (54, 0, NULL, 'Warning', 'warning.index', 2, 1),
        (55, 0, NULL, 'Termination', 'termination.index', 2, 1),
        (56, 0, NULL, 'Promotion', 'promotion.index', 2, 1),
        (57, 20, NULL, 'Summary Report', 'attendanceSummaryReport.attendanceSummaryReport', 4, 1),
        (58, 0, NULL, 'Manage Work Hour', NULL, 5, 1),
        (59, 58, NULL, 'Approve Work Hour', 'workHourApproval.create', 5, 1),
        (60, 0, NULL, 'Employee Permanent', 'permanent.index', 2, 1),
        (61, 0, NULL, 'Manage Bonus', NULL, 5, 1),
        (62, 61, NULL, 'Bonus Setting', 'bonusSetting.index', 5, 1),
        (63, 61, NULL, 'Generate Bonus', 'generateBonus.index', 5, 1),
        (64, 18, NULL, 'Dashboard Attendance', 'attendance.dashboard', 4, 1),
        (65, 0, NULL, 'Front Setting', NULL, 11, 1),
        (66, 65, NULL, 'General Setting', 'front.setting', 11, 1),
        (67, 65, NULL, 'Front Service', 'service.index', 11, 1)");

    }
}
