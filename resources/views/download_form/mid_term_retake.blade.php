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
            font-size: 12px!important;
            padding: 2px 1px;
        }

        .bb-1 {
            border-bottom: 1px solid #000;
        }

        .b-none{
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
        .w-10{
            width: 10%;
        }
        .w-20{
            width: 20%;
        }
        .w-40{
            width: 40%;
        }

        /*margin*/
        .mt-1{
            margin-top: 2px;
        }
        .mt-5{
            margin-top: 10px;
        }

        .mt-25{
            margin-top: 50px;
        }

        .pdf_image {
            position: absolute;
            top: 8%;
            right: 28%;
            transform: translate(50%, -50%);
        }

        .student_image
        {
            position: absolute;
            top: 6%;
            right: 7%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

@php
        $url = '';
        $img = '';
        $decoded2 = json_decode($student, true);
        try{
            $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $decoded2['id'] . ".JPG");
            $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $decoded2['id'] . ".JPG";

            // $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

            if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){
             
                $url = env("APP_URL") . "images/student_profile_photo_" . $decoded2['id'] . ".jpg";
            }
        }
        catch (\Exception $exception){
            try{
                
                $url = env("APP_URL") . "images/student_profile_photo_" . $decoded2['id'] . ".jpg";
            }
            catch (\Exception $exception){
                $url = "";
            }
        }
        
    @endphp


<table class="b-none">
    <tr>
        <th class="bb-none"><strong style="font-size: 25px;">Dhaka International University</strong></th>
    </tr>

    <tr>
        <th class="bb-none"><strong style="font-size: 20px;">Department of {{ $decoded2['department']['department'] }}</strong></th>
    </tr>

    <tr>
        <th class="bb-none"><strong style="font-size: 20px;">Mid-term Retake Examination Form</strong></th>
    </tr>

    <tr>
        <th>(Fee Per Course TK 500)</th>
    </tr>
</table>

<table class="mt-1">
    <tr>
        <td style="width: 60%" class="bl-none bb-none bt-none">Name: <b> {{ $decoded2['name'] }}</b></td>
        <td class="w-40 bb-none">Receipt ......................... Date ............................</td>
    </tr>

    <tr>
        <td class="bl-none bb-none">Program: <b>{{ $decoded2['department']['name'] }}</b></td>
        <td class="bb-none"><b> {{ count($course_as_array) * 500 }} </b> (<span style="text-transform: capitalize;"><b>{{ \App\classes\NumberToWord::numberToWord(count($course_as_array) * 500) }} taka only</b></span>) cash received.</td>

    <tr>
        <td class="bl-none bb-none"> Roll No: <b>{{ $decoded2['roll_no'] }}</b> ; Batch: <b>{{ $decoded2['batch']['batch_name'] }}</b> ;  Reg. Code: <b>{{ $decoded2['reg_code'] }}</b> ;  Semester: <b>{{ $decoded2['current_semester']  }}</b></td>
        <td class="tr" style="padding-top: 40px;">Signature & Seal</td>
    </tr>
</table>


<table class="mt-1">
    <tr>
        <td class="w-10"><b>Sl. No. </b> </td>
        <td class="w-20"><b>Course Code </b> </td>
        <td class="tc"><b>Course Title </b> </td>
    </tr>

    @foreach($course_as_array as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row['course_code'] }}</td>
        <td>{{ $row['course_name']}}</td>
    </tr>
    @endforeach
   

</table>

<table class="mt-25 b-none">
    <tr>
        <td class="br-none">Signature of the Student</td>
        <td class="br-none">Signature of the Course Teacher</td>
        <td class="tr">Signature of the Departmental Chairman</td>
    </tr>
</table>

<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="Dhaka International University">
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