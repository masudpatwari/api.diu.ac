<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mid Term Retake </title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 12px !important;
            padding: 2px 1px;
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
        .w-10 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-40 {
            width: 40%;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-5 {
            margin-top: 10px;
        }

        .mt-25 {
            margin-top: 50px;
        }

        .mt-20 {
            margin-top: 42px;
        }

        .pdf_image {
            position: absolute;
            top: 10%;
            right: 28%;
            transform: translate(50%, -50%);
        }

        .student_image {
            position: absolute;
            top: 7%;
            right: 5%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

    
@php
    $url = '';
    $img = '';


    try {

        $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

        $img = pick_desired_image($url, 'image/jpeg');

        
        if(!$img)
        {
            $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".png";

            $img = pick_desired_image($url, 'image/png');

            if(!$img)
            {
                file_get_contents($url);
            }
        }


    } catch (\Exception $e) {

        try {

            if(@file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG")){
                $img = @file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG");
                $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG";
            }
    
            $img = file_get_contents_ssl($url);
    

            if($img != ''){
                if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){
                    $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";
    
                }
            }

            file_get_contents($url);

        } catch (\Exception $e) {
    
                $url = env("APP_URL") . "images/no_image.jpg";
                $img = @file_get_contents_ssl($url);
            }
        }

       // dd($url, $img);
@endphp


<table class="b-none">
    <tr>
        <th class="bb-none"><strong style="font-size: 25px;">Dhaka International University</strong></th>
    </tr>

    <tr>
        <th class="bb-none"><strong style="font-size: 20px;">Department
                of <br> {{ $student->department->department }}</strong></th>
    </tr>

    <tr>
        <th class="bb-none"><strong style="font-size: 20px;">Mid-term Retake Examination Form</strong></th>
    </tr>

    <tr>
        <th class="bb-none">(Fee Per Course TK 500)</th>
    </tr>

    <tr>
        <td class="tc">Form No: <b>{{ $otherStudentForm->id }}</b></td>
    </tr>
</table>

<table class="mt-20">
    <tr>
        <td style="width: 60%" class="bl-none bb-none bt-none">Name: <b> {{ $student->name }}</b></td>
        <td class="w-40 bb-none">Receipt. <b>{{ $otherStudentForm->receipt_no }}</b> Date:
            <b>{{ \Carbon\Carbon::parse($otherStudentForm->bank_payment_date)->format('d-m-Y') }}</b></td>
    </tr>

    <tr>
        <td class="bl-none bb-none">Program: <b>{{ $student->department->name }}</b></td>
        <td class="bb-none"><b> {{ $otherStudentForm->total_payable }} </b> (<span
                    style="text-transform: capitalize;"><b>{{ \App\classes\NumberToWord::numberToWord($otherStudentForm->total_payable) }} taka only</b></span>)
            cash received.
        </td>

    <tr>
        <td class="bl-none bb-none"> Roll No: <b>{{ $student->roll_no }}</b> ; Batch:
            <b>{{ $student->batch->batch_name }}</b> ; Reg. Code: <b>{{ $student->reg_code }}</b> ; Semester:
            <b>{{ $otherStudentForm->semester }}</b></td>
        <td class="tr" style="padding-top: 40px;">{{ $otherStudentForm->employee->name ?? 'N/A' }}
            , {{ $otherStudentForm->employee->relDesignation->name ?? 'N/A' }}</td>
    </tr>
</table>


<tabl
    @endforeach


</table>

<table class="mt-25 b-none">
    <tr>
        <td class="br-none">Signature of the Student</td>
        <td class="br-none">Signature of the Course Teacher</td>
        <td class="tr">Signature of the Departmental Chairman</td>
    </tr>
</table>e class="mt-1">
    <tr>
        <td class="w-10 tc"><b>Sl. No. </b></td>
        <td class="w-20 tc"><b>Course Code </b></td>
        <td class="tc"><b>Course Title </b></td>
    </tr>

    @foreach($otherStudentFormMidTermRetake as $row)
        <tr>
            <td class="tc">{{ $loop->iteration }}</td>
            <td class="tc">{{ $row['course_code'] }}</td>
            <td class="tc">{{ $row['course_name']}}</td>
        </tr>

<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="Dhaka International University">
</div>

<div class="student_image">
    <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                        ->merge($url, 0.3, true)
                        ->size(140)->errorCorrection('H')
                        ->generate($details)) !!} ">
</div>

</body>
</html>