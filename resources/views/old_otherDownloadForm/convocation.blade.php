<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Convocation</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 11px !important;
            padding: 0 5px;
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

        .w-16 {
            width: 22%;
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

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .pdf_image {
            position: absolute;
            top: 40%;
            left: 29%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>
@php
    $url = '';
    $img = '';
    $decode_student = json_decode($student ,true);
    try{
        $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $decode_student['id'] . ".JPG");
        $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $decode_student['id'] . ".JPG";

        // $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

        if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){

            $url = env("APP_URL") . "images/student_profile_photo_" . $decode_student['id'] . ".jpg";
        }
    }
    catch (\Exception $exception){
        try{

            $url = env("APP_URL") . "images/student_profile_photo_" . $decode_student['id'] . ".jpg";
        }
        catch (\Exception $exception){
            $url = "";
        }
    }

@endphp

<table>
    <tr>

        <th rowspan="3" class="w-20 b-none" style="padding-left: 0!important">

            @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode($img)?>' style="width:120px;"/>
            @else
                <p style="margin-top: 0.5in">Passport size photo</p>
            @endif
        </th>

        <th class="bt-none bb-none" style="width: 5%">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;">
        </th>

        <th class="b-none" style="width: 75%">
            <span style="font-size: 25px">Dhaka International University (DIU) <br>
                <span style="font-size: 14px;">House # 4, Road # 1, Block - F,
Banani, Dhaka-1213, Bangladesh</span>
            </span>
        </th>

    </tr>

    <tr>
        <th rowspan="2" class="bb-none bl-none br-none"></th>
        <th class="b-none" style="padding: 10px 0">
            <span style="font-size: 25px">Registration Form</span>
        </th>
    </tr>

    <tr>
        <th class="b-none">
            <span style="font-size: 25px">... <sup>th</sup>   Convocation</span>
        </th>
    </tr>

</table>

<table class="mt-1">
    <tr>
        <td class="w-30">Student's Name</td>
        <td colspan="3"><b>{{ $decode_student['name'] }}</b></td>
    </tr>
    <tr>
        <td>Father's Name</td>
        <td colspan="3"><b>{{ $decode_student['f_name'] }}</b></td>
    </tr>
    <tr>
        <td>Mother's Name</td>
        <td colspan="3"><b>{{ $decode_student['m_name'] }}</b></td>
    </tr>
    <tr>
        <td>Present Address</td>
        <td colspan="3"><b>{{ $decode_student['mailing_add'] ?? 'N/A' }}</b></td>
    </tr>
    <tr>
        <td>Permanent Address</td>
        <td colspan="3"><b>{{ $decode_student['parmanent_add'] ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td>Nationality</td>
        <td colspan="3"><b>{{ $decode_student['nationality'] ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td>Contact No. (Mobile)</td>
        <td><b>{{ $decode_student['phone_no'] ?? 'N/A' }}</b></td>
        <td class="w-16">E-mail Address</td>
        <td><b>{{ $decode_student['email'] ?? 'N/A' }}</b></td>
    </tr>
</table>

<table class="b-none mt-1">
    <tr style="margin-top: 5px;">
        <td class="b-none w-50">
            Name of the Program/Degree: <b>{{ $decode_student['department']['name'] ?? 'N/A' }}</b>
        </td>

        <td class="b-none w-50">
            Major in: <b>{{ $student_provisional_transcript_marksheet_info['batch_name_as_major'] }}</b>
        </td>
    </tr>
</table>

<table class="mt-1">
    <tr>
        <td class="w-16">Roll No</td>
        <td><b>{{ $decode_student['roll_no'] ?? 'N/A' }}</b></td>
        <td class="w-16">Registration No.</td>
        <td colspan="3"><b>{{ $decode_student['reg_code'] ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="w-16">Batch</td>
        <td><b>{{ $decode_student['batch']['batch_name'] ?? 'N/A' }}</b></td>
        <td class="w-16">Session.</td>
        <td><b>{{ $decode_student['batch']['sess'] ?? 'N/A' }}</b></td>
        <td class="w-20" colspan="2">Group: <b>{{ $decode_student['group']['name'] ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="w-20">Duration Of The Course</td>
        <td><b>{{ $student_provisional_transcript_marksheet_info['duration_in_month'] ?? '' }} (Month)</b></td>
        <td class="w-16">Shift (First/Second)</td>
        <td><b>{{ $decode_student['shift']['name'] ?? 'N/A' }}</b></td>
        <td class="w-20" colspan="2">Passing Year:
            @if($student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'])
                <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}</b>
            @else
                <b>N/A</b>
            @endif
        </td>
    </tr>

    <tr>
        <td class="w-16">Result (CGPA)</td>
        <td><b>{{ $student_provisional_transcript_marksheet_info['cgpa'] ?? 'N/A' }}</b></td>
        <td class="w-16">Result Pub. Date</td>
        <td colspan="3">
            @if($student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'])
                <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('d-m-Y') }}</b>
            @else
                <b>N/A</b>
            @endif
        </td>
    </tr>
</table>

<table class="mt-1 b-none">
    <tr>
        <td class="b-none">
            Name of the Program/Degree (For Dual Degree) :
            @if($second_degree == 'true')
                <b>{{ $program ?? '' }}</b>
            @endif
        </td>
    </tr>

    <tr>

        <td class="b-none">
            Major in:
            @if($second_degree == 'true')
                <b>{{ $major_in ?? '' }}</b>
            @endif
        </td>
    </tr>
</table>

<table class="mt-1">
    <tr>
        <td class="w-16">Roll No</td>
        <td>@if($second_degree == 'true')<b>{{ $roll_no ?? '' }}</b>@endif</td>
        <td class="w-16">Registration No.</td>
        <td colspan="3">@if($second_degree == 'true')<b>{{ $registration_no ?? '' }}</b>@endif</td>
    </tr>

    <tr>
        <td class="w-16">Batch</td>
        <td>@if($second_degree == 'true')<b>{{ $batch ?? '' }}</b>@endif</td>
        <td class="w-16">Session</td>
        <td>@if($second_degree == 'true')<b>{{ $student_session ?? '' }}</b>@endif</td>
        <td class="w-20" colspan="2">Group: @if($second_degree == 'true')<b>{{ $group ?? '' }}</b>@endif</td>
    </tr>

    <tr>
        <td class="w-20">Duration Of The Course</td>
        <td> @if($duration_of_the_course && $second_degree == 'true') <b>{{ $duration_of_the_course ?? '' }} (Month)</b> @endif</td>
        <td class="w-16">Shift (First/Second)</td>
        <td>@if($second_degree == 'true')<b>{{ $shift ?? '' }}</b>@endif</td>
        <td class="w-20" colspan="2">Passing Year: @if($second_degree == 'true')<b>{{ $passing_year ?? '' }}</b>@endif</td>
    </tr>

    <tr>
        <td class="w-16">Result (CGPA)</td>
        <td>@if($second_degree == 'true')<b>{{ $result ?? '' }}</b>@endif</td>
        <td class="w-16">Result Pub. Date</td>
        <td colspan="3">
            @if($result_published_date && $second_degree == 'true')
                <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $result_published_date) ?? '')->format('d-m-Y') }}</b>
            @endif
        </td>
    </tr>
</table>

<table class="mt-1 b-none">
    <tr>
        <td class="b-none">
            Essential Particulars
        </td>
    </tr>

    <tr>
        <td class="bb-none"> i) 2 Copies of Passport Size Colour Photo with Name,Department,Batch & Roll No written on
            back.
        </td>
    </tr>

    <tr>
        <td class="bb-none"> ii) Photocopies of Provisional Certificate/Transcript to be Verified by the Deputy
            Controller/Joint Controller/Controller of the Examinations of DIU.
        </td>
    </tr>

    <tr>
        <td class="bb-none"> iii) SSC,HSC or Diploma or equivalent & Graduation certificates and transcripts must be
            verified by the authorized officer of DIU.
        </td>
    </tr>


    <tr>
        <td style="padding: 10px 5px" class="bb-none">Registration fee: Tk.6000 (For Single Degree) and TK.8000 (For
            Double Degree).
        </td>
    </tr>

    <tr>
        <td class="bb-none">Declaration: I do hereby agree with any decision of DIU authority regarding convocation. As
            per my knowledge above all information are true. Before taking original certificate, I will surrender
            provisional certificate to the office of the Controller of Examinations.
        </td>
    </tr>
</table>

<table class="b-none" style="margin-top: 45px">
    <tr>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
        <td class="tc b-none "><strong>Authorized Officer</strong></td>
        <td rowspan="2" class="tc"><strong>Candidate's Signature <br> & Date</strong></td>
    </tr>

    <tr>
        <td class="tc br-none">Seal & Sign (Accounts Office)</td>
        <td class="tc br-none">Seal & Sign (Controller Office)</td>
        <td class="tc b-none">Seal & Sign (Registrar Office)</td>
    </tr>
</table>

<table class="b-none">
    <tr style="margin-top: 2px;">
        <td class="tc" style="padding: 20px 0">
            ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        </td>
    </tr>
</table>

<div style="width: 100%">

    <div style="width: 79%;float: left;">
        <table>
            <tr>
                <td colspan="2">Student's Name</td>
                <td colspan="4"><b>{{ $decode_student['name'] ?? 'N/A' }}</b></td>
            </tr>

            <tr>
                <td colspan="2">Name of the Program/Degree:</td>
                <td colspan="4"><b>{{ $decode_student['department']['name'] ?? 'N/A' }}</b></td>
            </tr>

            <tr>
                <td colspan="2" class="w-20">Roll No. : <b>{{ $decode_student['roll_no'] ?? 'N/A' }}</b></td>
                <td>Registration No</td>
                <td colspan="3"><b>{{ $decode_student['reg_code'] ?? 'N/A' }}</b></td>
            </tr>

            <tr>
                <td colspan="2">Batch: <b>{{ $decode_student['batch']['batch_name'] ?? 'N/A' }} </b></td>
                <td colspan="2">Shift: <b>{{ $decode_student['shift']['name'] ?? 'N/A' }} </b></td>
                <td colspan="2">Session: <b>{{ $decode_student['batch']['sess'] ?? 'N/A' }} </b></td>
            </tr>

            <tr>
                <td colspan="3">Duration of the Course:
                    <b>{{ $student_provisional_transcript_marksheet_info['duration_in_month'] ?? '' }} (Month) </b></td>
                <td colspan="3">Passing Year :

                    @if($student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'])
                        <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }} </b>
                    @else
                        <b>N/A</b>
                    @endif

                    Result (CGPA):

                    <b>{{ $student_provisional_transcript_marksheet_info['cgpa'] ?? 'N/A' }} </b>

                </td>

            </tr>
        </table>
    </div>

    <!-- <div style="width: 1%;float: left;">
        <table>
            <tr>
                <td class="bt-none"></td>
            </tr>
        </table>
    </div> -->

    <div style="width: 20%;float: left;margin-left:10px;">
        <table>
            <tr>
                <td class="b-none tc">
                    @if($img)
                        <img src='data:image/jpeg;base64,<?=base64_encode($img)?>' style="width:120px;"/>
                    @else
                        <p style="margin-top: 0.5in">Passport size photo</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>


</div>

<table class="b-none" style="margin-top: 50px;">
    <tr>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
    </tr>
</table>


<div class="pdf_image">
    <img src="{{ storage_path('assets/convocation.png') }}" alt="">
</div>

</body>
</html>