<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transcript</title>

    <style>
        body {
            font-family: timesNewRoman;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        thead {
            vertical-align: top;
            text-align: center;
            font-weight: normal;
        }

        th,
        td {
            padding: 0.2em;
            vertical-align: top;
            border: 0px solid #000;
        }

        h3 {
            font-size: 1.2em
        }

        h4 {
            font-size: 1em
        }

        h5 {
            font-size: 0.8em
        }

        h6 {
            font-size: 1em;
        }

        table.header_table,
        table.transcript_table {
            /*margin-bottom: 0.5em*/
        }

        table.header_table tr td {
            padding: 0;
        }

        table.award tr th,
        table.award tr td {
            padding: 0.23em;
            border: 1px solid #000;
            font-size: 0.54em;
            text-align: center;
        }

        table.std_info tr th,
        table.std_info tr td {
            padding: 0.2em;
            font-size: 0.8em;
        }

        table.transcript_table tr th,
        table.transcript_table tr td {
            border: 1px solid #000;
            font-size: 15px;
            padding: .55em .3em;
        }

        table.summary_table tr th,
        table.summary_table tr td {
            border: 1px solid #000;
            font-size: 16px;
            padding: .2em .2em;
        }

        table.footer_table tr th {
            padding: 0.3em;
            border: 1px solid #000;
            font-size: 0.8em;
        }

        table.footer_table tr td {
            padding: 0.5em 0
        }

        table.signature_table tr td {
            font-size: 0.8em;
        }

        .tc {
            text-align: center;
        }

        @page {
            margin-top: 0.6in;
            margin-left: 0.2in;
            margin-right: 0.2in;
        }

        .footer {
            position: absolute;
            bottom: 2%;
            left: 2%;
            right: 2%;
            transform: translate(50%, -50%);
        }

        .major {
            position: absolute;
            top: 19%;
            left: 25.5%;
            transform: translate(50%, -50%);
            width: 350px;
            height: 100px;
        }
    </style>

</head>
<body>

@php
    $major = '';
    $status = false;

    if (str_contains($student_info['batch']['batch_name'],'Finance')){
        $major = 'Finance';
        $status = true;
    }

     if (str_contains($student_info['batch']['batch_name'],'Marketing')){
        $major = 'Marketing';
        $status = true;
     }

    if (str_contains($student_info['batch']['batch_name'],'Human')){
                $major = 'Human Resource Management';
                $status = false;
                }

    if (str_contains($student_info['batch']['batch_name'],'Accounting')){
                $major = 'Accounting and Information Systems';
                $status = false;
    }
@endphp

<table class="header_table">
    <tr>
        <td colspan="3"
            style="padding-bottom: 18px;font-size: 25px;text-transform: uppercase;letter-spacing: 2px;font-weight: bold;padding-left: 135px">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-bottom: 18px;font-size: 23px;text-align: center;font-weight: bold;">Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 21px;text-align: center;font-weight: bold;padding-bottom: 10px">Master of Business
            Administration Examination
            - {{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}</td>
    </tr>

    <tr>
        <td width="1.9in">
            <table class="award">
                <tr>
                    <th colspan="3">Award Of Grade</th>
                </tr>
                <tr>
                    <th style="width: 44%">Mark Range (%)</th>
                    <th style="width: 30%">Letter Grade</th>
                    <th style="width: 30%">Grade Point</th>
                </tr>
                @foreach($grade_point_system_details AS $grade_point_system_details_key => $grade_point_system_details_value)
                    @if($grade_point_system_details_key == 0)
                        <tr>
                            <td>{{ $grade_point_system_details_value['pc_mark'] }} and above</td>
                            <td style="font-weight: bold">{{ $grade_point_system_details_value['letter'] }}</td>
                            <td style="font-weight: bold">{{ sprintf('%0.2f', $grade_point_system_details_value['grade_point']) }}</td>
                        </tr>
                    @elseif((sizeof($grade_point_system_details)-1) == $grade_point_system_details_key)
                        <tr>
                            <td>
                                Below {{ $grade_point_system_details[$grade_point_system_details_key-1]['pc_mark'] }}</td>
                            <td style="font-weight: bold">{{ $grade_point_system_details_value['letter'] }}</td>
                            <td style="font-weight: bold">{{ sprintf('%0.2f', $grade_point_system_details_value['grade_point']) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $grade_point_system_details_value['pc_mark'] }} to less
                                than {{ $grade_point_system_details[$grade_point_system_details_key-1]['pc_mark'] }}</td>
                            <td style="font-weight: bold">{{ $grade_point_system_details_value['letter'] }}</td>
                            <td style="font-weight: bold">{{ sprintf('%0.2f', $grade_point_system_details_value['grade_point']) }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </td>
        <td align="center" valign="middle" style="padding-top: 170px;font-size: 16px;font-weight: bold">
            Name : <span style="text-transform: capitalize">{{ $student_info['name'] }}</span>
        </td>
        <td align="right" width="2.2in">
            <table class="std_info" style="border: 1px solid #000000">
                <tr>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;">Issue No.</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8px 0;text-align: left;"><b>{{ $otherStudentForm->issue_no ?? '' }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;">Date</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8px 0;text-align: left;">
                        <b>{{ \Carbon\Carbon::parse($otherStudentForm->date)->format('d-m-Y') }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;">Roll No.</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;"><b>{{ $student_info['roll_no'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;">Regn. No.</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;"><b>{{ $student_info['reg_code'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 10.5px 0;text-align: left;">Session</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8px 0;text-align: left"><b>{{ $student_info['session_name'] }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

@if(!empty($transcript_data))
    <table class="transcript_table" style="margin-top: 20px">
        @foreach ($transcript_data as $transcript_data_key => $transcript_data_value)
            <tr>
                <th colspan="5" class="text-center text-uppercase" style="font-size: 16px;padding: 8px 0">
                    {{ \App\Libraries\EnglishAlphabeticNumber::number($transcript_data_value['semester']) }}
                    SEMESTER
                </th>
            </tr>
            <tr>
                @if($transcript_data_key == 0)
                    <th style="width: 15%">Course <br> No.</th>
                    <th style="text-align: left">Course Title</th>
                    <th style="width: 12%">Credit Hours</th>
                    <th style="width: 12%">Grade Earned</th>
                    <th style="width: 12%">Grade Point</th>
                @endif
            </tr>

            @if (is_array($transcript_data_value['allocated_courses']))
                @foreach($transcript_data_value['allocated_courses'] as $allocateSubject)
                    <tr>
                        <td class="tc">{{ $allocateSubject['code'] }}</td>
                        <td>{{ $allocateSubject['name'] }}</td>
                        <td class="tc">{{ $allocateSubject['credit'] }}</td>

                        @if($transcript_data_value['exempted'] == 0)
                            <td class="tc"><b>{{ $allocateSubject['marks']['letter_grade'] ?? '' }}</b></td>
                            <td class="tc"><b>{{ $allocateSubject['marks']['grade_point'] ?? '' }}</b></td>
                        @else
                            <td colspan="2" style="text-align: center;font-weight: bold;"><b>Incomplete</b></td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5"
                        style="text-align: center">{{ $transcript_data_value['allocated_courses'] ?? '' }}</td>
                </tr>
            @endif

        @endforeach
    </table>
@endif


@if(!empty($transcript_result))
    <table class="summary_table">
        <tr>
            <th style="text-align: left;border-right: 1px solid #FFFFFF;font-size: 16px;padding:10px 5px">Total Credit
                Required
                : {{ $transcript_result['total_credit_required'] }}</th>
            @if(!empty($transcript_result['exempted_credit']))
                <th>Credit Exempted : {{ $transcript_result['exempted_credit'] }}</th>
            @endif
            <th style="border-right: 1px solid #FFFFFF;font-size: 16px;padding:10px 5px">Credit Earned
                : {{ $transcript_result['total_credit_earned'] }}</th>
            <th style="border-right: 1px solid #FFFFFF;font-size: 16px;padding:10px 5px">Average Grade
                : {{ $transcript_result['grade_letter'] }}</th>
            <th style="text-align: right;font-size: 16px;padding:10px 5px">CGPA
                : {{ sprintf('%0.2f', $transcript_result['cgpa']) }}</th>
        </tr>
        <tr>
            <th style="text-align: left;border-left: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;border-bottom: 2px solid #FFFFFF;font-size: 16px;padding-top: 15px;padding-left: -1px">
                Result
                Published
                on {{ \Carbon\Carbon::parse($otherStudentForm->result_published_date)->format('d-m-Y') }}
            </th>
            <th style="text-align: center;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;font-size: 16px;padding-top: 15px;"
                colspan="3">Major of instruction in English
            </th>
        </tr>
    </table>
@endif

<div class="footer">
    <table class="signature_table" style="margin-top: 10px">
        <tr>
            <td align="left" style="width: 2in">
                <p><strong>Administrative Building</strong></p>
                <p>House # 6, Road # 1, Block - F</p>
                <p>Banani, Dhaka - 1213</p>
                <p>Bangladesh</p>
            </td>
            <td style="padding: 0.5in 0.2in 0 0.2in;">
                <p><strong>Prepared by</strong> ........................</p>
            </td>
            <td style="padding: 0.5in 0.2in 0 0.2in;">
                <p><strong>Compared by</strong> ........................</p>
            </td>
            <td style="padding: 0.5in 0 0 0.2in;">
                <p><strong>Controller of Examinations</strong></p>
            </td>
        </tr>
    </table>
</div>

<div class="major">
    <h3 style="margin-bottom: 5px;" class="tc">Major in
        @if ($status)
            {{ $major }}
        @endif
    </h3>

    @if (!$status)
        <h3 class="tc"> {{ $major }}</h3>
    @endif
</div>

</body>