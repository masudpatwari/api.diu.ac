<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Professional Short Course</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 17px !important;
            padding: 5px 0px;
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
        .w-55 {
            width: 55%;
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

        .w-35 {
            width: 35%;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-5 {
            margin-top: 10px;
        }

        .custom-btn {
            padding: 5px 15px!important;
            height: 40px;
            letter-spacing: 1px;
            font-size: 18px;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px;
            color: #fff;
            font-weight: bold;
            background: #000;
            border: none;
        }

        .pdf_image {
            position: absolute;
            top: 30%;
            left: 29%;
            transform: translate(50%, -50%);
        }

        .student_image
        {
            position: absolute;
            top: 30%;
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
        <th rowspan="5" class="bt-none bb-none br-none">
            <img src="{{ storage_path('assets/cecd.png') }}" alt="Dhaka International University" style="width: 100px;padding:0 8px">
        </th>

        <th colspan="2" class="b-none" style="width: 85%">
            <span style="font-size: 16px">Centre for Excellence and Career Development (CECD)</span>
        </th>

        <th rowspan="5" class="bt-none bb-none bl-none">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;padding:0 8px">
        </th>
    </tr>

    <tr>
        <th colspan="2" class="tc b-none"><span style="font-size: 18px">Dhaka International University</span></th>
        
    </tr>

    <tr>
        <td colspan="2" class="tc b-none">66,Green Road,Dhaka-1205</td>
    
    </tr>

    <tr>
        <td colspan="2" class="tc b-none">Cell: 01732604439 , E-mail:cecd@diu-bd.net</td>
    
    </tr>

    <tr>
        <td colspan="2" class="tc b-none">Web: www.diu.ac</td>
        
    </tr>

    <tr>
        <td colspan="2" class="br-none bt-none">SL. No: ..................</td>
    
        <td colspan="2" class="bl-none tr bt-none">Date: <b>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</b> </td>
    </tr>


</table>

<table class="b-none mt-5">
    <tr>
        <td class="tc" style="padding: 10px 5px">
            <span class="custom-btn">Application Form for Professional Short Certificate Course</span>
        </td>
    </tr>
</table>

<table class="mt-5 b-none">
    <tr class="b-none">
        <td class="w-35">Applicant's Name</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5"> <b>{{ $student->name ?? '' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td>Father's Name</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5"> <b>{{ $student->f_name ?? '' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td>Course Name</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5">Advance English Language Course.</td>
    </tr>

    <tr class="b-none">
        <td>Course Fee</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5">2300/-</td>
    </tr>

    <tr class="b-none">
        <td>Own Student / Outsider</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5"> Own Student </td>
    </tr>

    <tr class="b-none">
        <td>Department (own students)</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5"> <b>{{ $student->department->department ?? '' }}</b> </td>
        {{-- <td class="bl-none">Roll No :19</td>
        <td class="bl-none">Batch: 78</td>
        <td class="bl-none">Session: 2019-2020</td> --}}
    </tr>

    <tr class="b-none">
        <td colspan="2">Roll No : <b>{{ $student->roll_no ?? '' }}</b></td>
        <td colspan="2" class="bl-none br-none">Batch: <b>{{ $student->batch->batch_name ?? '' }}</b> </td>
        <td colspan="3">Session: <b>{{ $student->batch->sess ?? '' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td>Phone / Mobile</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="3"> <b>{{ $student->phone_no ?? '' }}</b> </td>
        <td colspan="2" class="bl-none">E-mail: <b>{{ $student->email ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td>National ID</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5"> N/A </td>
    </tr>

    <tr class="b-none">
        <td rowspan="2">Permanent Address</td>
        <td class="w-1 bl-none br-none">: </td>
        <td colspan="5"> <b>{{ $student->parmanent_add ?? 'N/A' }}</b> </td>
    </tr>

</table>

<table style="margin-top: 50px;" class="b-none">
    <tr>
        <td><span style="border-top: 1px solid #000">Student's Signature</span></td>
        <td class="bl-none br-none bb-none"></td>
        <td class="w-50 tc"><span style="border-top: 1px solid #000">Departmental Chairman/Coordinator</span></td>
    </tr>

    <tr>
        <td colspan="2" class="bt-none br-none"></td>
        <td class="tc bt-none"> Signature with seal</td>
    </tr>
</table>

<table style="margin-top: 70px;">
    <tr>
        <td rowspan="2" class="bb-none w-55">
            Receipt No ..........................Date: .................. <br>

            Received TK. <b>2300.00</b> (<span style="text-transform: capitalize;"><b>{{ \App\classes\NumberToWord::numberToWord(2300) }}</b></span>) only.
        </td>
        <td class="tr bt-none br-none bb-none">...................................................</td>
    </tr>
    <tr>
        <td class="tr br-none bb-none" style="font-size: 10px;">Signature of the Authorized Officer with official seal</td>
    </tr>
    <tr>
        <td class="tr" style="padding-top: 50px;"><span style="border-top: 1px solid #000">Accounts Officer</span></td>
        <td class="br-none bb-none"></td>
    </tr>
</table>


<div class="pdf_image">
    <img src="{{ storage_path('assets/cecd_back.png') }}" alt="">
    
</div>

<div class="student_image">
    @if($img)
        <img src='data:image/jpeg;base64,<?=base64_encode( $img )?>' style="width:80px;"/>
    @else
        <p style="margin-top: 0.5in">Passport size photo</p>
    @endif
</div>


</body>
</html>