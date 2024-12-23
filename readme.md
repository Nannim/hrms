
Royex is a Human Resource and payroll management software. For maintaining HR & Payroll department of any company

##Royex - Human Resource and Payroll Management Software
Documentation:
Online Documentation
Human Resource and payroll management

    Dashboard
    Administration 
        Role Management
        Changing Password
    Employee Management
        Department
        Designation
        Branch
        Employee Manage
        Warning
        Termination
        Promotion
        Employee Permanent
    Leave Management
        Setup
            Manage Holiday
            Public holiday
            Weekly holiday
            Leave type
            Earn Leave configure
        Leave Application
            Apply for leave
            Public holiday
        Leave Application
            Leave Report
            Summary Report
            My Leave Report

    Attendance
        Setup
            Manage Work Shift
        Report
            Daily Attendance
            Monthly Attendance 
            My Attendance Report
            Summary Report 
        Manual Attendance  
    Payroll
        Setup
            Tax Rule Setup
            Late Configuration
        Allowance
        Deduction
        Monthly Pay Grade
        Hourly Pay Grade 
        Salary Sheet Generation
        Report
            Payment History
            My Payroll
        Manage Work Hour
            Approve Work Hour
        Manage Bonus
            Bonus Setting
            Generate Bonus

How to setup or Install

    1) Screenshot(Step 1): Login to your Cpanel/VPS/Hosting Panel, Create MySQL Database, Create New User & Add/Grant user to the Database. You can follow this tutorial- https://www.youtube.com/watch?v=qSdbNoW2f-c
    2) Screenshot(Step 2): Go to PHPMyAdmin, select your newly created Database, go to import & import “hrms.sql” from folder downloaded_project_folder->db->hrms.sql.
    3) Now from the File Manager of your hosting go to the corresponding directory where you want to install Laravel Backend. You can use domain root, directory & sub-domain too.
    4) Use file from belontor.zip.
    5) Upload zip, extract zip file on the corresponding directory(maybe some .htaccess configuration changing needed, depends on your hosting environment).
    6) Screenshot(Step 3): Edit .env file from Laravel Root
        APP_NAME: Your Backend App name
        APP_URL: Root URL of your Backend App
        DB_HOST: Host of your Database(Usually 127.0.0.1 or localhost)
        DB_PORT: Port of your Database(Usually 3306)
        DB_DATABASE: Database Name
        DB_USERNAME: Username of your Database User
        DB_PASSWORD: Password of your Database User
        Make Sure You Have Selected PHP version above 5.6.4

Advantage of Royex

    Nice and Simple Design
    Dashboard with whole software at a glance
    Same Panel for both employee and admin
    Fast data load
    Used store procedure and view for smoothness
    Ajax pagination
    Live data filtering
    Smooth Report and PDF generating

Server Requirements

    PHP >= 5.6.4n
    OpenSSL PHP Extension
    PDO PHP Extension
    Mbstring PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension

