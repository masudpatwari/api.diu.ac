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
            font-size: 15.5px;
            padding: 5px 2px;
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
            margin-top: 0.7in;
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
    </style>

</head>
<body>

<table class="header_table">
    <tr>
        <td colspan="3"
            style="padding-bottom: 24px;font-size: 26px;text-transform: uppercase;letter-spacing: 2px;font-weight: bold;padding-left: 135px">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-bottom: 24px;font-size: 24px;text-align: center;font-weight: bold;">Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 20px;text-align: center;font-weight:800;padding-bottom: 24px;font-weight: bold;">M.Sc. in Computer Science &
            Engineering
            Examination
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
        <td align="center" valign="middle" style="padding-top: 60px;font-size: 16px;font-weight: bold">
            Name : <span style="text-transform: capitalize;">{{ $student_info['name'] }}</span>
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
                    <td style="padding: 8px 0;text-align: left;"><b>{{ \Carbon\Carbon::parse($otherStudentForm->date)->format('d-m-Y') }}</b></td>
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

@if(!empty($transcript_data))
    <table class="transcript_table" style="margin-top: 20px">

        <tr>
            <th colspan="5" class="text-center text-uppercase" style="font-size: 18px;padding: 10px 0">
                FIRST SEMESTER
            </th>
        </tr>
        <tr>
            <th style="width: 14%">Course No.</th>
            <th style="text-align: left;">Course Title</th>
            <th style="width: 15%">Credit Hours</th>
            <th style="width: 15%">Grade Earned</th>
            <th style="width: 15%">Grade Point</th>
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-501</td>
            <td>Advanced Algorithm</td>
            @if(is_array($transcript_data[0]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CSE-501') }}</td>

                @if($transcript_data[0]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CSE-501')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CSE-501') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CSE-501') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-502</td>
            <td>Advanced Networking</td>
            @if(is_array($transcript_data[0]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CSE-502') }}</td>

                @if($transcript_data[0]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CSE-502')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CSE-502') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CSE-502') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-504</td>
            <td>Advanced Graph Theory</td>
            @if(is_array($transcript_data[0]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CSE-504') }}</td>

                @if($transcript_data[0]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CSE-504')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CSE-504') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CSE-504') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-529</td>
            <td>Advanced Logic Design</td>
            @if(is_array($transcript_data[0]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CSE-529') }}</td>

                @if($transcript_data[0]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CSE-529')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CSE-529') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CSE-529') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>

        <tr>
            <th colspan="5" class="text-center text-uppercase" style="font-size: 18px;padding: 10px 0">SECOND SEMESTER
            </th>
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-508</td>
            <td style="font-size: 14px;">Advanced Cryptography and Network Security</td>
            @if(is_array($transcript_data[1]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CSE-508') }}</td>

                @if($transcript_data[1]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CSE-508')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CSE-508') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CSE-508') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-512</td>
            <td style="font-size: 14px;">Advanced Wireless and Mobile Communication</td>
            @if(is_array($transcript_data[1]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CSE-512') }}</td>

                @if($transcript_data[1]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CSE-512')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CSE-512') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CSE-512') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-519</td>
            <td>Machine Learning</td>
            @if(is_array($transcript_data[1]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CSE-519') }}</td>

                @if($transcript_data[1]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CSE-519')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CSE-519') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CSE-519') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-524</td>
            <td>Advanced Digital Image Processing</td>
            @if(is_array($transcript_data[1]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CSE-524') }}</td>

                @if($transcript_data[1]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CSE-524')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CSE-524') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CSE-524') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>

        <tr>
            <th colspan="5" class="text-center text-uppercase" style="font-size: 18px;padding: 10px 0">THIRD SEMESTER
            </th>
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-503</td>
            <td>Advanced Database</td>
            @if(is_array($transcript_data[2]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CSE-503') }}</td>

                @if($transcript_data[2]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CSE-503')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CSE-503') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CSE-503') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-526</td>
            <td>Advanced Digital Communication</td>
            @if(is_array($transcript_data[2]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CSE-526') }}</td>

                @if($transcript_data[2]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CSE-526')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CSE-526') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CSE-526') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>
        <tr>
            <td class="tc" style="padding-bottom: 14px">CSE-531</td>
            <td>Project Work</td>
            @if(is_array($transcript_data[2]['allocated_courses']))
                <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CSE-531') }}</td>

                @if($transcript_data[2]['exempted'] == 0)

                    @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CSE-531')))
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CSE-531') }}</b>
                        </td>
                        <td class="tc">
                            <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CSE-531') }}</b>
                        </td>
                    @else
                        <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                    @endif
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                @endif
            @else
                <td colspan="3" style="text-align: center;font-size: 14px;">Semester or Marks not
                    exists
                </td>
            @endif
        </tr>

    </table>
@endif


@if(!empty($transcript_result))
    <table class="summary_table">
        <tr>
            <th style="text-align: left;border-right: 1px solid #FFFFFF;font-size: 15px">Total Credit Required
                : {{ $transcript_result['total_credit_required'] }}</th>
            @if(!empty($transcript_result['exempted_credit']))
                <th>Credit Exempted : {{ $transcript_result['exempted_credit'] }}</th>
            @endif
            <th style="border-right: 1px solid #FFFFFF;font-size: 15px">Credit Earned
                : {{ $transcript_result['total_credit_earned'] }}</th>
            <th style="border-right: 1px solid #FFFFFF;font-size: 15px">Average Grade
                : {{ $transcript_result['grade_letter'] }}</th>
            <th style="text-align: right;font-size: 15px">CGPA
                : {{ sprintf('%0.2f', $transcript_result['cgpa']) }}</th>
        </tr>
        <tr>
            <th style="text-align: left;border-left: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;border-bottom: 2px solid #FFFFFF;font-size: 15px;padding-top: 13px">
                Result
                Published
                on {{ \Carbon\Carbon::parse($otherStudentForm->result_published_date)->format('d-m-Y') }}
            </th>
            <th style="text-align: center;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;font-size: 15px;padding-top: 13px"
                colspan="3">Medium of instruction in English
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
</body>