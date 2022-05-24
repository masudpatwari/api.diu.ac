<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Re Admission Form</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 13px !important;
            padding: 5px 2px;
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

        .w-35{
            width: 35%;
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

        .w-15 {
            width: 15%;
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

        .w-25 {
            width: 25%;
        }

        .w-33 {
            width: 33.33%;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-5 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 40px;
        }

        .mt-55 {
            margin-top: 110px;
        }

        .custom-btn {
            padding: 5px 25px;
            height: 50px;
            letter-spacing: 1px;
            font-size: 30px;
            font-weight: 700;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px!important;
            color: #fff;
            background: #000;
            border: none;
        }

        .pdf_image {
            position: absolute;
            top: 32%;
            right: 28%;
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

<table>

    <tr class="b-none">
        <th class="w-20 b-none" rowspan="4">
            @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode( $img )?>' style="width:130px;"/>
            @else
                <p style="margin-top: 0.5in">Passport size photo</p>
            @endif
        </th>

        <th colspan="2" class="bt-none bb-none br-none">
            <span style="font-size: 30px;">Dhaka International University</span>
        </th>

    </tr>

    {{-- <tr>
        <td class="tc bb-none br-none" colspan="2"><span style="font-size: 16px;"><b>ddd</b></span></td>
    </tr> --}}

    <tr>
        <td class="tc bt-none br-none" colspan="2"><span style="font-size: 16px;">House No. 04, Road No. 01, Block - F, Banani, Dhaka-1213</span>
        </td>
    </tr>

    <tr>
        <td class="tr bb-none bt-none"><span
                style="font-size: 10px;">Phone: +880255040891-7, Fax: +88-02-55040898</span>
        </td>

        <td class="tc w-35" style="border-top: 1px solid #000;"><b>Re Admission Fee</b></td>
    </tr>

    <tr>
        <td class="tc bt-none bb-none" style="padding-left: 22%;padding-top: 5px;padding-bottom: 5px;">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;">
        </td>

        <td>
            <span style="font-size: 10px;">
                Under Graduate - 5000/- (First Time) <br>
                Under Graduate - 10000/- (Second Time) <br>
                Master's Program - 6000/- (First Time) <br>
                Master's Program - 12000/- (Second Time)
            </span>
        </td>

    </tr>

    <tr>
        <td rowspan="2" class="bl-none bb-none br-none"></td>
        <td rowspan="2" class="tr bb-none bl-none"><span class="custom-btn">Re-Admission Form</span></td>
        <td class="tc"><b>Session Fee</b></td>

    </tr>

    <tr>
        <td>
            <span style="font-size: 8px;">Under Graduate Program - 5000/- (Per Session) <br>
           Master's Program - 6000/- (Per Session)</span>
        </td>
    </tr>

</table>

<table class="b-none mt-5">
    <tr>
        <td class="b-none">1.</td>
        <td colspan="7" class="b-none w-30">Department / Program : <b>{{ $student->department->name ?? 'N/A' }}</b></td>
    </tr>
    <tr>
        <td class="b-none">2.</td>
        <td class="b-none" colspan="7">Name of the Student : <b>{{ $student->name ?? 'N/A' }}</b></td>
    </tr>
    <tr>
        <td class="b-none">3.</td>
        <td class="b-none" colspan="7">Father's Name : <b>{{ $student->f_name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="b-none">4.</td>
        <td colspan="7" class="b-none">Mother's Name : <b>{{ $student->m_name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td>5.</td>
        <td class="b-none w-15">Batch : <b>{{ $student->batch->batch_name ?? 'N/A' }}</b></td>
        <td class="b-none w-15">Roll No: <b>{{ $student->roll_no ?? 'N/A' }}</b></td>
        <td colspan="5" class="b-none">Reg. No : <b>{{ $student->reg_code ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="bt-none">6.</td>
        <td colspan="4" class="bl-none bt-none bb-none br-none">Session: <b>{{ $student->batch->sess ?? 'N/A' }}</b></td>
        <td class="bt-none bb-none br-none">Group No: <b>{{ $student->group->name ?? 'N/A' }}</b></td>
        <td colspan="2" class="bt-none bb-none br-none">Mobile: <b>{{ $student->phone_no ?? 'N/A' }}</b></td>
    </tr>
    <tr>
        <td class="b-none">7.</td>
        <td colspan="7" class="bt-none">Photocopies of Last Semester Final Examinations Admit Card / Transcript to be enclosed here with.</td>

    </tr>
</table>

<table class="b-none mt-20">

    <tr class="b-none">
        <td class="w-20 tr">.......................................</td>
    </tr>

    <tr class="b-none">
        <td class="w-20 tr">Signature of the Student</td>
    </tr>

    <tr class="b-none">
        <td class="w-20 tr">Date: <b>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</b></td>
    </tr>

</table>

<table class="b-none mt-10">

    <tr>
        <td>...........................................................................................................................</td>
    </tr>
    <tr>
        <td class="bt-none"><b>Remarks, Signature and Seal From Department Chairman / Coordinator</b></td>
    </tr>
</table>

<table class="mt-5">

    <tr>
        <td colspan="2" style="text-transform: uppercase;letter-spacing: 10px" class="tc"> <b>Only for Office use</b></td>
    </tr>
    <tr>
        <td style="padding: 10px 5px;" class="tc w-50 bb-none"><b>(After Re-admission, Student's New Details)</b></td>
        <td style="padding-top: 20px;" class="bb-none">Receipt No. .............................. Date ............................</td>
    </tr>
    <tr>
        <td style="padding-top: 20px;" class="bb-none">Batch : ..................................... ; Roll No: ...................</td>
        <td style="padding-top: 20px;" class="bb-none">Received Tk. ............................ (......... . . . . . . . . . . ......................................................)only</td>
    </tr>

    <tr>
        <td style="padding-top: 20px;" class="bb-none">Reg. Code: <b>{{ $student->reg_code ?? 'N/A' }}</b> </td>
        <td style="padding-top: 20px;" class="tr" rowspan="2">Signature & Seal</td>
    </tr>

    <tr>
        <td style="padding-top: 30px;">Session: <b>{{ $student->batch->sess ?? 'N/A' }}</b> </td>
    </tr>
</table>


<table class="b-none mt-55">
    <tr>
        <td class="tc br-none"><span style="border-top: 1px solid #000;">Authorized Officer</span>
        </td>
        <td class="w-50 tc"><span style="border-top: 1px solid #000;">Additional Registrar / Student Advisor</span></td>
        <td class="w-30 tc bl-none"><span style="border-top: 1px solid #000;">Registrar</span></td>
    </tr>
</table>

<div class="pdf_image">
     <img src="{{ storage_path('assets/diu_back.png') }}" alt="Dhaka International University">
</div>


</body>
</html>