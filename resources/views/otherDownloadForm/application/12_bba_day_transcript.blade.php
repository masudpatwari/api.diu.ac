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
            font-size: 0.5em;
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
            font-size: 11.5px;
            padding: 3.2px 4px;
        }

        table.summary_table tr th,
        table.summary_table tr td {
            border: 1px solid #000;
            font-size: 10px;
            padding: .23em .2em;
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

        @page {
            margin-top: 0.5in;
            margin-left: 0.2in;
            margin-right: 0.2in;
        }

        .tc {
            text-align: center;
        }

        .footer {
            position: absolute;
            bottom: 1.5%;
            left: 2%;
            right: 2%;
            transform: translate(50%, -50%);
        }

        .major {
            position: absolute;
            top: 17%;
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

    $nine_sub_one_title ='';
    $nine_sub_one_name ='';
    $nine_sub_one_code ='';

    $nine_sub_two_title ='';
    $nine_sub_two_name ='';
    $nine_sub_two_code ='';

    $nine_sub_three_title ='';
    $nine_sub_three_name ='';
    $nine_sub_three_code ='';

    $nine_sub_four_title ='';
    $nine_sub_four_name ='';
    $nine_sub_four_code ='';


    $ten_sub_one_title ='';
    $ten_sub_one_name ='';
    $ten_sub_one_code ='';
    $ten_sub_two_title ='';
    $ten_sub_two_name ='';
    $ten_sub_two_code ='';
    $ten_sub_three_title ='';
    $ten_sub_three_name ='';
    $ten_sub_three_code ='';
    $ten_sub_four_title ='';
    $ten_sub_four_name ='';
    $ten_sub_four_code ='';

    $twelve_sub_one_title ='';
    $twelve_sub_one_name ='';
    $twelve_sub_one_code ='';

    $twelve_sub_two_title ='';
    $twelve_sub_two_name ='';
    $twelve_sub_two_code ='';

    if (str_contains($student_info['batch']['batch_name'],'Finance')){
        $major = 'Finance';
        $status = true;

        $nine_sub_one_title ='FIN 411';
        $nine_sub_one_name ='Research Methodology';
        $nine_sub_one_code ='FIN-411';

        $nine_sub_two_title ='FIN 412';
        $nine_sub_two_name ='Project management';
        $nine_sub_two_code ='FIN-412';

        $nine_sub_three_title ='FIN 413';
        $nine_sub_three_name ='Financial Analysis and Control';
        $nine_sub_three_code ='FIN-413';

        $nine_sub_four_title ='FIN 414';
        $nine_sub_four_name ='Corporate Finance';
        $nine_sub_four_code ='FIN-414';


        $ten_sub_one_title ='FIN 421';
        $ten_sub_one_name ='Real Estate Finance';
        $ten_sub_one_code ='FIN-421';

        $ten_sub_two_title ='FIN 422';
        $ten_sub_two_name ='Working Capital Management';
        $ten_sub_two_code ='FIN-422';

        $ten_sub_three_title ='FIN 423';
        $ten_sub_three_name ='Investment Banking and Lease Financing';
        $ten_sub_three_code ='FIN-423';

        $ten_sub_four_title ='FIN 424';
        $ten_sub_four_name ='International Financial Management';
        $ten_sub_four_code ='FIN-424';


        $twelve_sub_one_title ='';
        $twelve_sub_one_name ='';
        $twelve_sub_one_code ='FIN-431';

        $twelve_sub_two_title ='';
        $twelve_sub_two_name ='';
        $twelve_sub_two_code ='FIN-432';

    }

    if (str_contains($student_info['batch']['batch_name'],'Marketing')){
            $major = 'Marketing';
            $status = true;

            $nine_sub_one_title ='Mkt 411';
            $nine_sub_one_name ='Research Methodology';
            $nine_sub_one_code ='MKT-411';

            $nine_sub_two_title ='Mkt 412';
            $nine_sub_two_name ='Project management';
            $nine_sub_two_code ='MKT-412';

            $nine_sub_three_title ='Mkt 413';
            $nine_sub_three_name ='Strategic Marketing';
            $nine_sub_three_code ='MKT-413';

            $nine_sub_four_title ='Mkt 414';
            $nine_sub_four_name ='Marketing Information Systems';
            $nine_sub_four_code ='MKT-414';


            $ten_sub_one_title ='Mkt 421';
            $ten_sub_one_name ='Global Marketing';
            $ten_sub_one_code ='MKT-421';

            $ten_sub_two_title ='Mkt 422';
            $ten_sub_two_name ='E- Marketing';
            $ten_sub_two_code ='MKT-422';

            $ten_sub_three_title ='Mkt 423';
            $ten_sub_three_name ='Integrated Marketing Communications';
            $ten_sub_three_code ='MKT-423';

            $ten_sub_four_title ='Mkt 424';
            $ten_sub_four_name ='Customer Relationship Management';
            $ten_sub_four_code ='MKT-424';

            $twelve_sub_one_title ='';
            $twelve_sub_one_name ='';
            $twelve_sub_one_code ='MKT-431';

            $twelve_sub_two_title ='';
            $twelve_sub_two_name ='';
            $twelve_sub_two_code ='MKT-432';
        }

    if (str_contains($student_info['batch']['batch_name'],'Human')){
            $major = 'Human Resource Management';
            $status = false;

            $nine_sub_one_title ='HRM 411';
            $nine_sub_one_name ='Research Methodology';
            $nine_sub_one_code ='HRM-411';

            $nine_sub_two_title ='HRM 412';
            $nine_sub_two_name ='Project Management';
            $nine_sub_two_code ='HRM-412';

            $nine_sub_three_title ='HRM 413';
            $nine_sub_three_name ='Human Resource Planning';
            $nine_sub_three_code ='HRM-413';

            $nine_sub_four_title ='HRM 414';
            $nine_sub_four_name ='Performance Management & Compensation Management';
            $nine_sub_four_code ='HRM-414';


            $ten_sub_one_title ='HRM 421';
            $ten_sub_one_name ='Industrial Relations';
            $ten_sub_one_code ='HRM-421';

            $ten_sub_two_title ='HRM 422';
            $ten_sub_two_name ='Organizational Development';
            $ten_sub_two_code ='HRM-422';

            $ten_sub_three_title ='HRM 423';
            $ten_sub_three_name ='Career Management';
            $ten_sub_three_code ='HRM-423';

            $ten_sub_four_title ='HRM 424';
            $ten_sub_four_name ='Human Resource Management Practices in Bangladesh';
            $ten_sub_four_code ='HRM-424';

            $twelve_sub_one_title ='';
            $twelve_sub_one_name ='';
            $twelve_sub_one_code ='HRM-431';

            $twelve_sub_two_title ='';
            $twelve_sub_two_name ='';
            $twelve_sub_two_code ='HRM-432';
        }

    if (str_contains($student_info['batch']['batch_name'],'Accounting')){
            $major = 'Accounting and Information Systems';
            $status = false;

            $nine_sub_one_title ='AIS 411';
            $nine_sub_one_name ='Research Methodology';
            $nine_sub_one_code ='AIS-411';

            $nine_sub_two_title ='AIS 412';
            $nine_sub_two_name ='Project Management';
            $nine_sub_two_code ='AIS-412';

            $nine_sub_three_title ='AIS 413';
            $nine_sub_three_name ='Financial Accounting';
            $nine_sub_three_code ='AIS-413';

            $nine_sub_four_title ='AIS 414';
            $nine_sub_four_name ='Management Accounting';
            $nine_sub_four_code ='AIS-414';


            $ten_sub_one_title ='AIS 421';
            $ten_sub_one_name ='Accounting Theory';
            $ten_sub_one_code ='AIS-421';

            $ten_sub_two_title ='AIS 422';
            $ten_sub_two_name ='Advanced Cost Accounting';
            $ten_sub_two_code ='AIS-422';

            $ten_sub_three_title ='AIS 423';
            $ten_sub_three_name ='Corporate Financial Reporting';
            $ten_sub_three_code ='AIS-423';

            $ten_sub_four_title ='AIS 424';
            $ten_sub_four_name ='Corporate Tax Planning';
            $ten_sub_four_code ='AIS-424';

            $twelve_sub_one_title ='';
            $twelve_sub_one_name ='';
            $twelve_sub_one_code ='AIS-431';

            $twelve_sub_two_title ='';
            $twelve_sub_two_name ='';
            $twelve_sub_two_code ='AIS-432';
        }
@endphp

<table class="header_table">
    <tr>
        <td colspan="3"
            style="padding-bottom: 12px;font-size: 25px;text-transform: uppercase;letter-spacing: 2px;font-weight: bold;padding-left: 135px">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="padding-bottom: 12px;font-size: 23.5px;text-align: center;font-weight: bold;letter-spacing: 1px">
            Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 22px;text-align: center;font-weight: bold;">Bachelor of Business
            Administration Examination
            - {{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}</td>
    </tr>

    <tr>
        <td width="1.85in">
            <table class="award">
                <tr>
                    <th colspan="3">Award Of Grade</th>
                </tr>
                <tr>
                    <th style="width: 44%">Mark Range (%)</th>
                    <th style="width: 29%">Letter Grade</th>
                    <th style="width: 27%">Grade Point</th>
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
        <td align="center" valign="middle" style="padding-top: 135px;font-size: 16px;font-weight: bold">
            Name : <span style="text-transform: capitalize">{{ $student_info['name'] }}</span>
        </td>
        <td align="right" width="2.2in">
            <table class="std_info" style="border: 1px solid #000000">
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Issue No.</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8px 0;text-align: left;"><b>{{ $otherStudentForm->issue_no ?? '' }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Date</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8px 0;text-align: left;">
                        <b>{{ \Carbon\Carbon::parse($otherStudentForm->date)->format('d-m-Y') }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Roll No.</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;"><b>{{ $student_info['roll_no'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Regn. No.</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;"><b>{{ $student_info['reg_code'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Session</td>
                    <td style="padding: 8px 0">:</td>
                    <td></td>
                    <td style="padding: 8px 0;text-align: left"><b>{{ $student_info['session_name'] }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="transcript_table" style="margin-top: 5px">
    {{--1 and 2 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">FIRST SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SECOND SEMESTER</th>
    </tr>
    <tr>
        <th>Course <br> No.</th>
        <th>Course Title</th>
        <th style="width: 6%">Credit Hours</th>
        <th style="width: 7%">Grade Earned</th>
        <th style="width: 6%">Grade Point</th>

        <th>Course <br> No.</th>
        <th>Course Title</th>
        <th style="width: 6%">Credit Hours</th>
        <th style="width: 7%">Grade Earned</th>
        <th style="width: 6%">Grade Point</th>
    </tr>
    <tr>
        <td class="tc">CCB 111</td>
        <td>Introduction to Business</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CCB-111') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CCB-111')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CCB-111') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CCB-111') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 121</td>
        <td>Fundamentals of Management</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CCB-121') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CCB-121')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CCB-121') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CCB-121') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 112</td>
        <td>Business English</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CCB-112') }}</td>
            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CCB-112')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CCB-112') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CCB-112') }}</b>
                    </td>

                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif


        <td class="tc">CCB 122</td>
        <td>Business Mathematics-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CCB-122') }}</td>

            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CCB-122')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CCB-122') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CCB-122') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

    </tr>

    <tr>
        <td class="tc">CCB 113</td>
        <td>Business Mathematics-I</td>
        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CCB-113') }}</td>

            @if($transcript_data[0]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CCB-113')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CCB-113') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CCB-113') }}</b>
                    </td>

                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif


        <td class="tc">CCB 123</td>
        <td>Business Communication</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CCB-123') }}</td>

            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CCB-123')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CCB-123') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CCB-123') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 114</td>
        <td>Bangldesh Studies</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CCB-114') }}</td>
            @if($transcript_data[0]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CCB-114')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CCB-114') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CCB-114') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
                <td style="text-align: center;font-weight: bold;font-size: 6px">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif


        <td class="tc">CCB 124</td>
        <td>Principales of Finance</td>
        @if(is_array($transcript_data[1]['allocated_courses']))

            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CCB-124') }}</td>
            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CCB-124')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CCB-124') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CCB-124') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

    </tr>
    {{--1 and 2 semester--}}

    {{--3 and 4 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">THIRD SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">FOURTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">CCB 131</td>
        <td>Principles of Marketing</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CCB-131') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CCB-131')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CCB-131') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CCB-131') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 211</td>
        <td>Business Statistics-I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'CCB-211') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'CCB-211')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'CCB-211') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'CCB-211') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 132</td>
        <td>Basic Accounting</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CCB-132') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CCB-132')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CCB-132') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CCB-132') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 212</td>
        <td>Intermediate Accounting</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'CCB-212') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'CCB-212')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'CCB-212') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'CCB-212') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 133</td>
        <td>Microeconomics</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CCB-133') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CCB-133')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CCB-133') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CCB-133') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 213</td>
        <td style="font-size: 10px">Computer Application in Business</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'CCB-213') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'CCB-213')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'CCB-213') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'CCB-213') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>


        <td class="tc">CCB 214</td>
        <td>Macroeconomics</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'CCB-214') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'CCB-214')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'CCB-214') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'CCB-214') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    {{--3 and 4 semester--}}


    {{--5 and 6 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">FIFTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SIXTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">CCB 221</td>
        <td>Business Statistics-II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CCB-221') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CCB-221')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CCB-221') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CCB-221') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 231</td>
        <td>Industrial Psychology</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'CCB-231') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'CCB-231')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'CCB-231') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'CCB-231') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 222</td>
        <td>Business Law</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CCB-222') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CCB-222')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CCB-222') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CCB-222') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 232</td>
        <td>Cost Accounting</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'CCB-232') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'CCB-232')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'CCB-232') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'CCB-232') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 223</td>
        <td>Financial Management</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CCB-223') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CCB-223')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CCB-223') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CCB-223') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 233</td>
        <td>Marketing Management</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'CCB-233') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'CCB-233')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'CCB-233') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'CCB-233') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 224</td>
        <td>E - Commerce</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CCB-224') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CCB-224')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CCB-224') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CCB-224') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
    </tr>
    {{--5 and 6 semester--}}


    {{--7 and 8 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SEVENTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">EIGHTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">CCB 311</td>
        <td>International Trade</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CCB-311') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CCB-311')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CCB-311') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CCB-311') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB-321</td>
        <td>Operations Managment</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CCB-321') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CCB-321')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CCB-321') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CCB-321') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 312</td>
        <td>Taxation</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CCB-312') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CCB-312')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CCB-312') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CCB-312') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 322</td>
        <td>Auditing</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CCB-322') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CCB-322')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CCB-322') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CCB-322') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 313</td>
        <td>Industrial and Labor Law</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CCB-313') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CCB-313')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CCB-313') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CCB-313') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">CCB 323</td>
        <td>Human Resource Management</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CCB-323') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CCB-323')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CCB-323') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CCB-323') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 314</td>
        <td>Organizational Behavior</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CCB-314') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CCB-314')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CCB-314') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CCB-314') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
    </tr>

    {{--7 and 8 semester--}}

    {{--9 and 10 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">NINTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">TENTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">CCB 331</td>
        <td>Insurance & Risk Management</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CCB-331') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CCB-331')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CCB-331') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CCB-331') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">{{ $nine_sub_one_title }}</td>
        <td>{{ $nine_sub_one_name }}</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],$nine_sub_one_code) }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],$nine_sub_one_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],$nine_sub_one_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],$nine_sub_one_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 332</td>
        <td>Bank Management</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CCB-332') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CCB-332')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CCB-332') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CCB-332') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">{{ $nine_sub_two_title }}</td>
        <td>{{ $nine_sub_two_name }}</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],$nine_sub_two_code) }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],$nine_sub_two_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],$nine_sub_two_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],$nine_sub_two_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CCB 333</td>
        <td style="font-size: 10px;">Management Information Systems</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CCB-333') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CCB-333')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CCB-333') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CCB-333') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">{{ $nine_sub_three_title }}</td>
        <td>{{ $nine_sub_three_name }}</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],$nine_sub_three_code) }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],$nine_sub_three_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],$nine_sub_three_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],$nine_sub_three_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>

        <td class="tc">{{ $nine_sub_four_title }}</td>
        <td>{{ $nine_sub_four_name }}</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],$nine_sub_four_code) }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],$nine_sub_four_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],$nine_sub_four_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],$nine_sub_four_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    {{--9 and 10 semester--}}


    {{--11 and 12 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">ELEVENTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">TWELFTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">{{ $ten_sub_one_title }}</td>
        <td>{{ $ten_sub_one_name }}</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],$ten_sub_one_code) }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],$ten_sub_one_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],$ten_sub_one_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],$ten_sub_one_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td>Internship/Project</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],$twelve_sub_one_code) }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],$twelve_sub_one_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],$twelve_sub_one_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],$twelve_sub_one_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">{{ $ten_sub_two_title }}</td>
        <td>{{ $ten_sub_two_name }}</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],$ten_sub_two_code) }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],$ten_sub_two_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],$ten_sub_two_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],$ten_sub_two_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td>Viva Voce</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],$twelve_sub_two_code) }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],$twelve_sub_two_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],$twelve_sub_two_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],$twelve_sub_two_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">{{ $ten_sub_three_title }}</td>
        <td style="{{  $major != 'Human Resource Management' ? 'font-size: 9px' :'' }}">{{ $ten_sub_three_name }}</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],$ten_sub_three_code) }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],$ten_sub_three_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],$ten_sub_three_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],$ten_sub_three_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
    </tr>

    <tr>
        <td class="tc">{{ $ten_sub_four_title }}</td>
        <td style="font-size: 10px;">{{ $ten_sub_four_name }}</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],$ten_sub_four_code) }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],$ten_sub_four_code)))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],$ten_sub_four_code) }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],$ten_sub_four_code) }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">Semester or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
    </tr>

    {{--11 and 12 semester--}}

</table>

@if(!empty($transcript_result))
    <table class="summary_table">
        <tr>
            <th style="text-align: left;border-right: 1px solid #FFFFFF;">Total Credit
                Required
                : {{ $transcript_result['total_credit_required'] }}</th>
            @if(!empty($transcript_result['exempted_credit']))
                <th>Credit Exempted : {{ $transcript_result['exempted_credit'] }}</th>
            @endif
            <th style="border-right: 1px solid #FFFFFF;">Credit Earned
                : {{ $transcript_result['total_credit_earned'] }}</th>
            <th style="border-right: 1px solid #FFFFFF;">Average Grade
                : {{ $transcript_result['grade_letter'] }}</th>
            <th style="text-align: right;">CGPA
                : {{ sprintf('%0.2f', $transcript_result['cgpa']) }}</th>
        </tr>


        <tr>
            <th style="text-align: left;border-left: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;border-bottom: 2px solid #FFFFFF;font-size: 12px;padding-left: -1px; {{  $major != 'Human Resource Management' ? 'padding-top:15px' :'' }}">
                Result
                Published
                on {{ \Carbon\Carbon::parse($otherStudentForm->result_published_date)->format('d-m-Y') }}
            </th>
            <th style="text-align: center;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;font-size: 12px; {{  $major != 'Human Resource Management' ? 'padding-top:15px' :'' }}"
                colspan="3">Medium of instruction in English
            </th>
        </tr>
    </table>
@endif

<div class="footer">
    <table class="signature_table">
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
                <p><strong>Compared by</strong> .........................</p>
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