<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eligible Students For Exam</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 15px !important;
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

        .pdf_image {
            position: absolute;
            top: 40%;
            left: 29%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

<table>
    <tbody>
    <tr>
        <td class="b-none" rowspan="6">
            <img style="margin-top: -40px" width="120" src="{{ storage_path('assets/diu_logo.png') }}" alt="">
        </td>
        <td class="b-none tc">
            <h2>Dhaka International University</h2>
        </td>
    </tr>

    <tr>
        <td class="b-none tc">
            <h4>Eligible Students List For Examination</h4>
        </td>
    </tr>


    <tr>
        <td class="b-none tc">{{ $department_name ?? '' }}</td>
    </tr>
    <tr>
        <td class="b-none tc">Batch : {{ $department_short_code ?? '' }}-{{ $batch_name ?? '' }}</td>
    </tr>

    <tr>
        <td class="b-none tc">Semester : {{ $current_semester ?? '' }}</td>
    </tr>

    <tr>
        <td class="b-none tc">Date & Time : {{ \Carbon\Carbon::now()->format('d-m-Y h:i A') }}</td>
    </tr>
    </tbody>
</table>

<table style="margin-top: 20px">
    <thead>
    <tr>
        <th>Sl</th>
        <th>Roll</th>
        <th>Name</th>
        <th>Reg. Code</th>
        <th>Current Due</th>
    </tr>
    </thead>
    <tbody>


    @foreach($eligibleStudents as $key=>$student)
        <tr>
            <td class="tc">{{ $key+1 }}</td>
            <td class="tc">{{ $student['roll_no'] }}</td>
            <td>{{ $student['name'] }}</td>
            <td>{{ $student['reg_code'] }}</td>
            <td class="tc">{{ number_format($student['total_current_due']) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
</div>

</body>
</html>

