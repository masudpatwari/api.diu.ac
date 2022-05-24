<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permission For Exam</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 20px !important;
            padding: 0 5px;
        }


        .b-none {
            border-top: 2px solid #fff;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #fff;
            border-right: 2px solid #fff;
        }


        .bb-none {
            border-bottom: 2px solid #fff;
        }


        .tl {
            text-align: left;
        }

        .tc {
            text-align: center;
        }

        .tr {
            text-align: right;
        }

        /*width*/
        .w-1 {
            width: 1%;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-16 {
            width: 16%;
        }

        .w-25 {
            width: 25%;
        }

        .w-30 {
            width: 30%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }

        .fs-18{
            font-size: 18px!important;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-10 {
            margin-top: 20px;
        }

        .custom-btn {
            padding: 5px 15px;
            height: 40px;
            letter-spacing: 1px;
            font-size: 30px;
            font-weight: 400;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px;
            color: #d6d6d6;
            background: blueviolet;
            border: none;
        }

        .student_image
        {
            position: absolute;
            top: 55%;
            right: 7%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

    @php
        $url = '';
        $img = '';
        try{
            $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG");
            $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG";

            // $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

            if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){
             
                $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";
            }
        }
        catch (\Exception $exception){
            try{
                
                $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";
            }
            catch (\Exception $exception){
                $url = "";
            }
        }
        
    @endphp

<table class="b-none">
    <tr>
        <td>
            Date: <b>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</b>
        </td>
    </tr>
</table>

<table class="b-none mt-15">
    <tr>
        <td class="bb-none">The Honorable Chairman / Vice-Chairman</td>
    </tr>
    <tr>
        <td class="bb-none">Board of Trustees</td>
    </tr>
    <tr>
        <td>Dhaka International University</td>
    </tr>
</table>

<table class="b-none mt-10">
    <tr>
        <td><strong>Subject: Prayer for Permission to sit for the Examination.</strong></td>
    </tr>
</table>


<table class="b-none mt-10">
    <tr>
        <td class="bb-none">Dear Sir,</td>
    </tr>
    <tr>
        <td class="bb-none">
            With due respect and humble submission, I would like to state that I am a student
            of <b>{{ $student->department->name ?? '' }}</b> Program/ Department. I have already paid TK. <b>{{ $last_payment['amount'] }} ( <b>{{ \Carbon\Carbon::parse($last_payment['pay_date'])->format('d-m-Y') }}</b> )</b> as my exam’s fee.But
            TK. <b>{{ number_format($student_account_info_summary['summary']['total_current_due'] ?? '',2) }}</b> is due. I will pay the due <b>{{ $payment_amount }}</b> on <b>{{ \Carbon\Carbon::parse($payment_date)->format('d-m-Y') }}</b>. That is why, I need permission to
            sit for the exam on Date: <b>{{ \Carbon\Carbon::parse($exam_date)->format('d-m-Y') }}</b> only.
        </td>
    </tr>


    <tr>
        <td style="padding: 15px 5px">
            I, therefore, pray and hope that you would kind enough to give me the permission to sit for the examination
            and oblige thereby.
        </td>
    </tr>
</table>

<table class="b-none mt-10">
    <tr>
        <td class="bb-none">Yours faithfully,</td>
    </tr>
    <tr>
        <td class="bb-none fs-18" style="padding-top: 85px"><b>{{ $student->name ?? '' }}</b> </td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Program: <b>{{ $student->department->name ?? '' }}</b></td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Batch: <b>{{ $student->batch->batch_name ?? '' }} </b> , Roll No: <b>{{ $student->roll_no ?? '' }}</b></td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Semester: <b>{{ $student->current_semester }}</b></td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Mobile Number: <b>{{ $student->phone_no ?? '' }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Last Paid: BDT. <b>{{ $last_payment['amount'] }}</b> at <b>{{ \Carbon\Carbon::parse($last_payment['pay_date'])->format('d-m-Y') }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Actual Total Fee: <b>{{ $student_account_info_summary['summary']['actual_total_fee'] ?? '' }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Special Scholarship: <b>{{ $student_account_info_summary['summary']['special_scholarship'] ?? '' }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Per Semester Fee Without Scholarship: <b>{{ $student_account_info_summary['summary']['per_semester_fee_without_scholarship'] ?? '' }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Per Semester Fee: <b>{{ $student_account_info_summary['summary']['per_semester_fee'] ?? '' }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Total Paid: <b>{{ $student_account_info_summary['summary']['total_paid'] ?? '' }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Total Current Due: <b>{{ number_format($student_account_info_summary['summary']['total_current_due'] ?? '',2) }}</b></td>
    </tr>

    <tr>
        <td class="bb-none fs-18">Total Due: <b>{{ $student_account_info_summary['summary']['total_due'] ?? '' }}</b></td>
    </tr>
</table>

<div class="student_image">
    @if($img)
        <img src='data:image/jpeg;base64,<?=base64_encode( $img )?>' style="width:80px;"/>
    @else
        <p style="margin-top: 0.5in">Passport size photo</p>
    @endif
</div>


</body>
</html>

