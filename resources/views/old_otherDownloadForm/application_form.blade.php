<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application Form</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 18px !important;
            padding: 1px 2px;
        }

        .bb-1 {
            border-bottom: 1px solid #000;
        }

        .b-none {
            border-top: 2px solid #fff;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #fff;
            border-right: 2px solid #fff;
        }

        .bt-none {
            border-top: 2px solid #fff;
        }

        .bb-none {
            border-bottom: 2px solid #fff;
        }

        .br-none {
            border-right: 2px solid #fff;
        }

        .bl-none {
            border-left: 2px solid #fff;
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

        .w-40 {
            width: 40%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 60%;
        }

        .w-30 {
            width: 30%;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-5 {
            margin-top: 10px;
        }

        .custom-btn {
            padding: 5px 15px;
            height: 40px;
            letter-spacing: 1px;
            font-size: 30px;
            font-weight: 700;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px;
            color: #fff;
            background: #000;
            border: none;
        }

        .pdf_image {
            position: absolute;
            top: 30%;
            left: 28%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

@php
    $url = '';
    $img = '';

    try{
        $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $otherStudentForm->student_id . ".JPG");
        $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $otherStudentForm->student_id . ".JPG";

        // $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

        if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){

            $url = env("APP_URL") . "images/student_profile_photo_" . $otherStudentForm->student_id . ".jpg";
        }
    }
    catch (\Exception $exception){
        try{

            $url = env("APP_URL") . "images/student_profile_photo_" . $otherStudentForm->student_id . ".jpg";
        }
        catch (\Exception $exception){
            $url = "";
        }
    }

@endphp

<table class="b-none">

    <tr>
        <th rowspan="4" class="bt-none bb-none br-none">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;">
        </th>

        <th class="b-none" style="width: 80%">
            <span style="font-size: 32px">Dhaka International University</span>
        </th>


    </tr>

    <tr>
        <th class="tc b-none"><span style="font-size: 18px">Administrative Building</span></th>
    </tr>

    <tr>
        <td class="tc b-none">House No.04, Road No. 01, Block - F, Banani,Dhaka-1213</td>
    </tr>

    <tr>
        <td class="tc b-none">Phone : 55040891-7, Fax: +88-02-55040898</td>
    </tr>


</table>

<table class=" mt-5">
    <tr>
        <td rowspan="2" class=" bt-none bl-none bb-none w-30">
            @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode($img)?>' style="width:130px;"/>
            @else
                <p style="margin-top: 0.5in">Passport size photo</p>
            @endif
        </td>

        <td class="bb-none bl-none bt-none"></td>

        <td class="tc w-40">
            <div style="padding: 50px 0"><strong>Tk. 500 only</strong><br>(For any one certificate)</div>
        </td>

    </tr>

    <tr>
        <td colspan="2" class="bl-none bb-none br-none"><span class="custom-btn">Application Form</span></td>
    </tr>
</table>

<table class="b-none mt-5">
    <tr>
        <td class="tc" style="font-size: 22px">
            For {{ $otherStudentForm->form_name ?? 'N/A' }}
        </td>
    </tr>
</table>

<table class="b-none" style="margin-top: 30px;">
    <tr class="b-none">
        <td class="br-none">1.</td>
        <td colspan="3">Name of Student : <b><span
                        style="text-transform: uppercase;">{{ $student->name ?? 'N/A' }}</span></b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none">2.</td>
        <td colspan="3">Father's Name : <b><span
                        style="text-transform: uppercase;">{{ $student->f_name ?? 'N/A' }}</span></b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none">3.</td>
        <td colspan="3">Mother's Name : <b><span
                        style="text-transform: uppercase;">{{ $student->m_name ?? 'N/A' }}</span></b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none">4.</td>
        <td colspan="3">Department : <b>{{ $student->department->department ?? 'N/A' }}</b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none">5.</td>
        <td colspan="2">Program : <b>{{ $student->department->name ?? 'N/A' }}</b></td>
        <td class="bl-none">Roll No : <b>{{ $student->roll_no ?? 'N/A' }}</b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none">6.</td>
        <td colspan="2">Registration No : <b>{{ $student->reg_code ?? 'N/A' }}</b></td>

        <td class="bl-none">Session : <b>{{ $student->batch->sess ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="br-none">7.</td>
        <td>Batch No : <b>{{ $student->batch->batch_name ?? 'N/A' }}</b></td>
        <td colspan="2" class="bt-none bb-none bl-none">Mobile : <b>{{ $student->phone_no ?? 'N/A' }}</b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none">8.</td>
        <td colspan="2">Result:CGPA / Class :
            <b>{{ $otherStudentForm->cgpa ?? 'N/A' }}</b></td>
        <td class="bl-none">Completed Semester : <b>{{ $student_account_info_summary['summary']['nos'] ?? 'N/A' }}</b>
        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none">9.</td>
        <td colspan="3">Photocopy of last Semester Final Examinations Admit Card / Transcript /</td>
    </tr>

    <tr class="b-none">
        <td class="br-none"></td>
        <td colspan="3">Marks Certificate / Provisional Certificate issued by this University to be</td>
    </tr>

    <tr class="b-none">
        <td class="br-none"></td>
        <td colspan="3">enclosed along with this application positively.</td>
    </tr>
</table>

<table style="margin-top: 70px;" class="b-none">
    <tr>
        <td> .............................. </td>
        <td rowspan="2" class="bl-none br-none"></td>
        <td  class="w-30 tc bb-none"><span style="border-top: 1px solid #000">Signature of the Student</span></td>
    </tr>

    <tr class="bt-none">
        <td class="bt-none">Authorized Officer</td>
        <td  class="w-50 tc">Date: <b>{{ \Carbon\Carbon::now()->format("d-m-Y") }}</b> </td>
    </tr>
</table>


<table style="margin-top: 40px;">
    <tr>
        <td rowspan="2" class="bl-none bt-none bb-none"></td>
        <td class="bb-none">
            Receipt No ............................... Date: ............................. <br>

            Received TK. <b>500.00</b> (<span style="text-transform: capitalize;"><b>five hundred</b></span>) only.
        </td>
        <td rowspan="2"  class="w-30 tc bt-none bb-none br-none"><span style="border-top: 1px solid #000">Registrar</span></td>
    </tr>

    <tr>
        <td class="tr" style="padding-top: 50px;"><span style="border-top: 1px solid #000">Accounts Officer</span></td>

    </tr>
</table>


<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
</div>


</body>
</html>

