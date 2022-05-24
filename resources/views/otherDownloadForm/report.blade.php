<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <style>

        /*@font-face {
            font-family: myFirstFont;
            src: url(sansation_light.woff);
        }*/

        .custom-font {
            /*font-family: myFirstFont;*/
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 16px !important;
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

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-10 {
            margin-top: 20px;
        }

        .mt-40 {
            margin-top: 80px;
        }

        .fs-18 {
            font-size: 18px !important;
        }

        .fs-16 {
            font-size: 14px !important;
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

        .pdf_image {
            position: absolute;
            top: 30%;
            left: 28%;
            transform: translate(50%, -50%);
        }

        .test{
            position: absolute;
            top: 2%;
            left: 10%;
            right: 10%;
        }

    </style>
</head>
<body>

<div class="test">
<table class="b-none ">
    <tr>
        <td class="bb-none" colspan="3">
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['name'] ?? '' }} ({{ $studentInfoWithCompleteSemesterResult['student']['id'] ?? '' }})
                , {{ $studentInfoWithCompleteSemesterResult['student']['reg_code'] ?? '' }}
                ({{ \Carbon\Carbon::parse($studentInfoWithCompleteSemesterResult['student']['adm_date'] ?? '')->format('d-m-Y') }}
                )</b>
        </td>
    </tr>

    <tr>
        <td class="bb-none" colspan="3">
            By:
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['employee']['emp_name'] ?? '' }} </b>, To:
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['department']['name'] ?? '' }} </b>
        </td>
    </tr>

    <tr>
        <td class="b-none custom-font" style="font-family: president">
            Batch: {{ $studentInfoWithCompleteSemesterResult['student']['batch']['batch_name'] ?? '' }}
        </td>
        <td class="b-none custom-font" style="font-family: president">
            Roll: {{ $studentInfoWithCompleteSemesterResult['student']['roll_no'] ?? '' }}
        </td>
        <td class="b-none custom-font" style="font-family: president">
            Session: {{ $studentInfoWithCompleteSemesterResult['student']['session_name'] ?? '' }}
        </td>
    </tr>

    <tr>
        @if(!array_key_exists('error', $studentInfoWithCompleteSemesterResult))
            <td class="b-none" colspan="2">
                <b>- - {{ $studentInfoWithCompleteSemesterResult['student']['total_paid'] ?? '' }}
                    - {{ $studentInfoWithCompleteSemesterResult['student']['total_paid'] ?? '' }}
                    - {{ $studentInfoWithCompleteSemesterResult['student']['special_scholarship'] ?? '' }}
                    = {{ $studentInfoWithCompleteSemesterResult['student']['actual_total_fee'] - $studentInfoWithCompleteSemesterResult['student']['total_paid'] - $studentInfoWithCompleteSemesterResult['student']['special_scholarship']  }}
                    / {{ $studentInfoWithCompleteSemesterResult['student']['total_due'] ?? '' }}</b>
            </td>
        <td class="b-none">
            Result:
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['cgpa'] }}</b>
        </td>
        @else
        <td class="b-none">
            Result:
            <b>Incomplete</b>
        </td>
        @endif
    </tr>

</table>
@if(!array_key_exists('error', $studentInfoWithCompleteSemesterResult))
    @if ($studentInfoWithCompleteSemesterResult['student']['studentSemesters'])
        <table>
            <thead>
            <tr>
                <th class="fs-16 tc">Semester</th>
                <th class="fs-16 tc">Created Date</th>
                <th class="fs-16 tc">Created By</th>
                <th class="fs-16 tc">Status</th>
                <th class="fs-16 tc">Result</th>
                <th class="fs-16 tc">CGPA</th>
            </tr>
            </thead>

            <tbody>
            @foreach($studentInfoWithCompleteSemesterResult['student']['studentSemesters'] as $studentSemester)
                <tr>
                    <td class="fs-16 tc">{{ $studentSemester['semester'] ?? '' }}</td>
                    <td class="fs-16 tc">{{ $studentSemester['created_at'] ?? '' }}</td>
                    <td class="fs-16 tc">{{ $studentSemester['created_by'] ?? '' }}</td>
                    <td class="fs-16 tc">{{ $studentSemester['status'] ?? '' }}</td>
                    <td class="fs-16 tc">{{ $studentSemester['semester_result'] ?? '' }}</td>
                    <td class="fs-16 tc">{{ $studentSemester['semester_gpa'] ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endif

@if(!array_key_exists('error', $studentInfoWithCompleteSemesterResult))
    <table class="b-none">

        @if($studentInfoWithCompleteSemesterResult['student']['incomplete_sub_code'])
            <tr>
                <td class="bb-none fs-16">Incomplete Subject Code:
                    <b>{{ $studentInfoWithCompleteSemesterResult['student']['incomplete_sub_code'] ?? '' }}</b></td>
            </tr>
        @endif


        @if ($studentInfoWithCompleteSemesterResult['student_re_admission'] || $studentInfoWithCompleteSemesterResult['student_transfer'])
            <tr>
                <td class="bb-none fs-16">Readmission / Transfer History:</td>
            </tr>
        @endif

        @if ($studentInfoWithCompleteSemesterResult['student_re_admission'])
            <tr>
                <td class="bb-none fs-16">
                    <b>{{ $studentInfoWithCompleteSemesterResult['student_re_admission']['date_'] }}
                        / {{ $studentInfoWithCompleteSemesterResult['student_re_admission']['employee']['emp_name'] ?? 'N/A' }}
                        (Readmission History)</b>
                </td>
            </tr>
        @endif

        @if ($studentInfoWithCompleteSemesterResult['student_transfer'])
            <tr>
                <td class="bb-none fs-16">
                    <b>{{ $studentInfoWithCompleteSemesterResult['student_transfer']['date_'] }}
                        / {{ $studentInfoWithCompleteSemesterResult['student_transfer']['employee']['emp_name'] ?? 'N/A' }}
                        (Transfer History)</b>
                </td>
            </tr>
        @endif

        @if ($transcriptStatus == 'Yes')
            <tr>
                <td class="fs-16">Data on certificate verification : <b>{{ $transcriptStatus }}</b></td>
            </tr>
        @endif

    </table>
@endif

<table class="mt-40 b-none">
    <tr>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Authorize officer</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Authorize officer</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Head of IT</td>
    </tr>
</table>


<table class="mt-40 b-none">
    <tr>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Received By</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Prepared By</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Compared By</td>
    </tr>
</table>


<table class="mt-40 b-none">
    <tr>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Print By</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Uploaded By</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Verified By (COE)</td>
    </tr>
</table>

<table class="mt-40 b-none">
    <tr>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Registrar</td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">VC / Pro-VC </td>
        <td class="b-none" style="width: 5%"></td>
        <td class="tc b-none" style="width: 30%;border-top: 3px dotted #000">Chairman / Vice-Chairman</td>
    </tr>
</table>

</div>



<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
</div>

</body>
</html>
