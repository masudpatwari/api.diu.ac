<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
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

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-10 {
            margin-top: 20px;
        }

        .fs-18 {
            font-size: 18px !important;
        }

        .fs-16 {
            font-size: 16px !important;
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

    </style>
</head>
<body>


<table class="b-none">
    <tr>
        <td class="bb-none" colspan="2">
            Student Name: <b>{{ $studentInfoWithCompleteSemesterResult['student']['name'] ?? '' }}</b>
        </td>
    </tr>

    <tr>
        <td class="bb-none" colspan="2">
            Reg. code: <b>{{ $studentInfoWithCompleteSemesterResult['student']['reg_code'] ?? '' }}</b>
        </td>
    </tr>

    <tr>
        <td class="bb-none" colspan="2">
            Admitted By:
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['employee']['emp_name'] ?? '' }}</b>
        </td>
    </tr>

    <tr>
        <td class="bb-none" colspan="2">
            Department:
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['department']['name'] ?? '' }}</b>
        </td>
    </tr>

    <tr>
        <td class="b-none">
            Batch: <b>{{ $studentInfoWithCompleteSemesterResult['student']['batch']['batch_name'] ?? '' }}</b>
        </td>
        <td class="b-none">
            Roll: <b>{{ $studentInfoWithCompleteSemesterResult['student']['roll_no'] ?? '' }}</b>
        </td>
    </tr>

    <tr>
        <td class="b-none">
            Admission Date:
            <b>{{ \Carbon\Carbon::parse($studentInfoWithCompleteSemesterResult['student']['adm_date'] ?? '')->format('d-m-Y') }}</b>
        </td>
        <td class="b-none">
            Total Fee: <b>{{ $studentInfoWithCompleteSemesterResult['student']['actual_total_fee'] ?? '' }}</b>
        </td>
    </tr>

    <tr>
        <td class="b-none">
            Total Paid: <b>{{ $studentInfoWithCompleteSemesterResult['student']['total_paid'] ?? '' }}</b>
        </td>
        <td>
            Total Due: <b>{{ $studentInfoWithCompleteSemesterResult['student']['total_due'] ?? '' }}</b>
        </td>
    </tr>

</table>


@if ($studentInfoWithCompleteSemesterResult['student']['studentSemesters'])
    <table class="mt-10">
        <thead>
        <tr>
            <th class="fs-16">Semester</th>
            <th class="fs-16">Created Date</th>
            <th class="fs-16">Created By</th>
            <th class="fs-16">Status</th>
            <th class="fs-16">Result</th>
            <th class="fs-16">CGPA</th>
        </tr>
        </thead>

        <tbody>
        @foreach($studentInfoWithCompleteSemesterResult['student']['studentSemesters'] as $studentSemester)
            <tr>
                <td class="fs-16">{{ $studentSemester['semester'] ?? '' }}</td>
                <td class="fs-16">{{ $studentSemester['created_at'] ?? '' }}</td>
                <td class="fs-16">{{ $studentSemester['created_by'] ?? '' }}</td>
                <td class="fs-16"></td>
                <td class="fs-16">{{ $studentSemester['semester_result'] ?? '' }}</td>
                <td class="fs-16">{{ $studentSemester['semester_gpa'] ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif


<table class="b-none mt-10">

    @if($studentInfoWithCompleteSemesterResult['student']['incomplete_sub_code'])
        <tr>
            <td class="bb-none fs-16">Incomplete Subject Code:
                <b>{{ $studentInfoWithCompleteSemesterResult['student']['incomplete_sub_code'] ?? '' }}</b></td>
        </tr>
    @endif

    <tr>
        <td class="bb-none fs-16">Final Result:
            <b>{{ $studentInfoWithCompleteSemesterResult['student']['cgpa'] }}</b>
        </td>
    </tr>


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

    <tr>
        <td class="fs-16">Data on certificate verification : <b>{{ $transcriptStatus }}</b></td>
    </tr>

</table>


<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
</div>

</body>
</html>
