<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bachelor of Pharmacy (Hons.)</title>

    <style>
        body {
            font-family: timesNewRoman;
            font-size: 11px;
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
            padding: 0.22em;
            border: 1px solid #000;
            font-size: 0.6em;
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
            font-size: 10px;
            padding: .15em .2em;
        }

        table.summary_table tr th,
        table.summary_table tr td {
            border: 1px solid #000;
            font-size: 8px;
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

        @page {
            margin-top: 0.4in;
            margin-left: 0.2in;
            margin-right: 0.2in;
        }

        .tc {
            text-align: center;
        }

        .footer {
            position: absolute;
            bottom: .8%;
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
            style="padding-bottom: 11px;font-size: 23px;text-transform: uppercase;letter-spacing: 2px;font-weight: bold;padding-left: 135px">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-bottom: 11px;font-size: 21px;text-align: center;font-weight: bold;">Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 20px;text-align: center;font-weight: bold;">Bachelor of Pharmacy (Hons.)
            Examination - {{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}</td></td>
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
            Name : <span style="text-transform: capitalize">{{ $student_info['name'] }}</span>
        </td>
        <td align="right" width="2.2in">
            <table class="std_info" style="border: 1px solid #000000">
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Issue No.</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;"><b>{{ $otherStudentForm->issue_no ?? '' }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Date</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;"><b>{{ \Carbon\Carbon::parse($otherStudentForm->date)->format('d-m-Y') }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Roll No.</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;"><b>{{ $student_info['roll_no'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Regn. No.</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;"><b>{{ $student_info['reg_code'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 8.4px 0;text-align: left;">Session</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left"><b>{{ $student_info['session_name'] }}</b></td>
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
        <th style="width: 4%">Course No.</th>
        <th style="width: 30%" class="tc">Course Title</th>
        <th style="width: 5%">Credit Hours</th>
        <th style="width: 6%">Grade Earned</th>
        <th style="width: 5%">Grade Point</th>

        <th style="width: 4%">Course No.</th>
        <th style="width: 30%">Course Title</th>
        <th style="width: 5%">Credit Hours</th>
        <th style="width: 6%">Grade Earned</th>
        <th style="width: 5%">Grade Point</th>
    </tr>

    <tr>
        <td class="tc">PHARM-101</td>
        <td>Inorganic Pharmacy-I</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'PHARM-101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'PHARM-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'PHARM-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'PHARM-101') }}</b>
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

        <td class="tc">PHARM-111</td>
        <td>Inorganic Pharmacy-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-111') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-111')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-111') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-111') }}</b>
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
        <td class="tc">PHARM-102</td>
        <td>Inorganic Pharmacy-I-Lab</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'PHARM-102') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'PHARM-102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'PHARM-102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'PHARM-102') }}</b>
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

        <td class="tc">PHARM-112</td>
        <td>Inorganic Pharmacy-II-Lab</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-112') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-112')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-112') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-112') }}</b>
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
        <td class="tc">PHARM-103</td>
        <td>Physical Pharmacy-I</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'PHARM-103') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'PHARM-103')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'PHARM-103') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'PHARM-103') }}</b>
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

        <td class="tc">PHARM-113</td>
        <td>Organic Pharmacy-I</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-113') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-113')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-113') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-113') }}</b>
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
        <td class="tc">PHARM-104</td>
        <td>Physical Pharmacy-I-Lab</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'PHARM-104') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'PHARM-104')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'PHARM-104') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'PHARM-104') }}</b>
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

        <td class="tc">PHARM-114</td>
        <td>Organic Pharmacy-I-Lab</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-114') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-114')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-114') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-114') }}</b>
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
        <td class="tc">MATH-101</td>
        <td>Mathematics & Statistics</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'MATH-101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'MATH-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'MATH-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'MATH-101') }}</b>
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

        <td class="tc">PHARM-115</td>
        <td>Physical Pharmacy-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-115') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-115')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-115') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-115') }}</b>
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
        <td class="tc">CS-101</td>
        <td>Computer Science</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CS-101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CS-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CS-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CS-101') }}</b>
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

        <td class="tc">PHARM-116</td>
        <td>Physical Pharmacy-II-Lab</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-116') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-116')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-116') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-116') }}</b>
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
        <td class="tc">HUM-101</td>
        <td>Introductory English</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'HUM-101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'HUM-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'HUM-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'HUM-101') }}</b>
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

        <td class="tc">PHARM-117</td>
        <td>Pharmacognosy-I</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-117') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-117')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-117') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-117') }}</b>
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

        <td class="tc">PHARM-118</td>
        <td>Pharmacognosy-I-Lab</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHARM-118') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHARM-118')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHARM-118') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHARM-118') }}</b>
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

        <td class="tc">HUM-111</td>
        <td>Bangladesh Studies</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'HUM-111') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'HUM-111')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'HUM-111') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'HUM-111') }}</b>
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

        <td class="tc">VV-111</td>
        <td>Viva-voce</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'VV-111') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'VV-111')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'VV-111') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'VV-111') }}</b>
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
        <td class="tc">PHARM-201</td>
        <td>Organic Pharmacy-II</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-201') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-201') }}</b>
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

        <td class="tc">PHARM-211</td>
        <td>Physiology-II</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-211') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-211')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-211') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-211') }}</b>
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
        <td class="tc">PHARM-202</td>
        <td>Organic Pharmacy-II-Lab</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-202') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-202') }}</b>
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

        <td class="tc">PHARM-212</td>
        <td>Physiology-II-Lab</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-212') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-212')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-212') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-212') }}</b>
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
        <td class="tc">PHARM-203</td>
        <td>Pharmacognosy-II</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-203') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-203')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-203') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-203') }}</b>
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

        <td class="tc">PHARM-213</td>
        <td>Pharmaceutical Microbiology-II</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-213') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-213')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-213') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-213') }}</b>
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
        <td class="tc">PHARM-204</td>
        <td>Pharmacognosy-II-Lab</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-204') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-204')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-204') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-204') }}</b>
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

        <td class="tc">PHARM-214</td>
        <td>Pharmaceutical Technology-I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-214') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-214')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-214') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-214') }}</b>
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
        <td class="tc">PHARM-205</td>
        <td>Basic Anatomy</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-205') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-205')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-205') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-205') }}</b>
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

        <td class="tc">PHARM-215</td>
        <td>Pharmaceutical Technology-I-Lab</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-215') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-215')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-215') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-215') }}</b>
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
        <td class="tc">PHARM-206</td>
        <td>Physiology-I</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-206') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-206')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-206') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-206') }}</b>
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

        <td class="tc">PHARM-216</td>
        <td>Pharmacology-I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-216') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-216')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-216') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-216') }}</b>
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
        <td class="tc">PHARM-207</td>
        <td>Physiology-I-Lab</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-207') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-207')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-207') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-207') }}</b>
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

        <td class="tc">PHARM-217</td>
        <td>Pharmacology-I-Lab</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-217') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-217')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-217') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-217') }}</b>
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
        <td class="tc">PHARM-208</td>
        <td>Pharmaceutical Microbiology-I</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-208') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-208')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-208') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-208') }}</b>
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

        <td class="tc">PHARM-218</td>
        <td>Biochemistry & Cellular Biology</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-218') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-218')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-218') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-218') }}</b>
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
        <td class="tc">PHARM-209</td>
        <td>Pharmaceutical Microbiology-I-Lab</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'PHARM-209') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'PHARM-209')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'PHARM-209') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'PHARM-209') }}</b>
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

        <td class="tc">PHARM-219</td>
        <td>Biochemistry & Cellular Biology-Lab</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'PHARM-219') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'PHARM-219')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'PHARM-219') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'PHARM-219') }}</b>
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

        <td class="tc">VV-211</td>
        <td>Viva-voce</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'VV-211') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'VV-211')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'VV-211') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'VV-211') }}</b>
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
        <td class="tc">PHARM-301</td>
        <td>Pharmaceutical Analysis-I</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-301') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-301')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-301') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-301') }}</b>
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

        <td class="tc">PHARM-311</td>
        <td>Pharmaceutical Analysis-II</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-311') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-311')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-311') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-311') }}</b>
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
        <td class="tc">PHARM-302</td>
        <td>Pharmaceutical Analysis-I-La</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-302') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-302')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-302') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-302') }}</b>
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

        <td class="tc">PHARM-312</td>
        <td>Pharmaceutical Analysis-II-Lab</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-312') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-312')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-312') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-312') }}</b>
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
        <td class="tc">PHARM-303</td>
        <td>Pharmaceutical Technology-II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-303') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-303')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-303') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-303') }}</b>
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

        <td class="tc">PHARM-313</td>
        <td>Pharmaceutical Technology-III</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-313') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-313')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-313') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-313') }}</b>
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
        <td class="tc">PHARM-304</td>
        <td>Pharmaceutical Technology-II-Lab</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-304') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-304')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-304') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-304') }}</b>
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

        <td class="tc">PHARM-314</td>
        <td>Pharmaceutical Technology-III-Lab</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-314') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-314')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-314') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-314') }}</b>
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
        <td class="tc">PHARM-305</td>
        <td>Pharmacology-II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-305') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-305')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-305') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-305') }}</b>
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

        <td class="tc">PHARM-315</td>
        <td>Pharmacology-III</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-315') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-315')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-315') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-315') }}</b>
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
        <td class="tc">PHARM-306</td>
        <td>Pharmacology-II-Lab</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-306') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-306')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-306') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-306') }}</b>
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

        <td class="tc">PHARM-316</td>
        <td>Pharmacology-III-Lab</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-316') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-316')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-316') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-316') }}</b>
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
        <td class="tc">PHARM-307</td>
        <td>Medicinal Chemistry-I</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-307') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-307')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-307') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-307') }}</b>
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

        <td class="tc">PHARM-317</td>
        <td>Medicinal Chemistry-II</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-317') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-317')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-317') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-317') }}</b>
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
        <td class="tc">PHARM-308</td>
        <td>Medicinal Chemistry-I-Lab</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-308') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-308')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-308') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-308') }}</b>
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

        <td class="tc">PHARM-318</td>
        <td>Medicinal Chemistry-II-Lab</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-318') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-318')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-318') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-318') }}</b>
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
        <td class="tc">PHARM-309</td>
        <td>Pathology</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-309') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-309')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-309') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-309') }}</b>
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

        <td class="tc">PHARM-319</td>
        <td>Hospital & Community Pharmacy</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'PHARM-319') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'PHARM-319')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'PHARM-319') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'PHARM-319') }}</b>
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
        <td class="tc">PHARM-310</td>
        <td style="font-size: 6px">Nutraceuticals, Dietary Supplements and Herbal Products</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'PHARM-310') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'PHARM-310')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'PHARM-310') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'PHARM-310') }}</b>
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

        <td class="tc">VV-311</td>
        <td>Viva-voce</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'VV-311') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'VV-311')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'VV-311') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'VV-311') }}</b>
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
    {{--5 and 6 semester--}}

    {{--7 and 8 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SEVENTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">EIGHTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">PHARM-401</td>
        <td>Pharmaceutical Analysis-III</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-401') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-401')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-401') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-401') }}</b>
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

        <td class="tc">PHARM-411</td>
        <td>Pharmaceutical Biotechnology</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-411') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-411')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-411') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-411') }}</b>
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
        <td class="tc">PHARM-402</td>
        <td>Pharmaceutical Analysis-III-Lab</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-402') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-402')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-402') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-402') }}</b>
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

        <td class="tc">PHARM-412</td>
        <td>Advance Pharmacology and Toxicology</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-412') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-412')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-412') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-412') }}</b>
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
        <td class="tc">PHARM-403</td>
        <td>Medicinal Chemistry-III</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-403') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-403')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-403') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-403') }}</b>
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

        <td class="tc">PHARM-413</td>
        <td>Biopharmaceutics & Pharmacokinetices - II</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-413') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-413')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-413') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-413') }}</b>
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
        <td class="tc">PHARM-404</td>
        <td>Cosmetology</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-404') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-404')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-404') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-404') }}</b>
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

        <td class="tc">PHARM-414</td>
        <td>Biopharmaceutics & Pharmacokinetices - II Lab</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-414') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-414')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-414') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-414') }}</b>
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
        <td class="tc">PHARM-405</td>
        <td>Cosmetology-Lab</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-405') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-405')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-405') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-405') }}</b>
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

        <td class="tc">PHARM-415</td>
        <td>Pharmaceutical Quality Control and Analytical Method Validation</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-415') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-415')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-415') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-415') }}</b>
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
        <td class="tc">PHARM-406</td>
        <td>Boipharmaceutics & Pharmacokinetics-I</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-406') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-406')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-406') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-406') }}</b>
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

        <td class="tc">PHARM-416</td>
        <td>Pharmaceutical Quality Control and Analytical Method Validation-Lab</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-416') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-416')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-416') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-416') }}</b>
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
        <td class="tc">PHARM-407</td>
        <td>Biopharmaceutics & Pharmacokinetics-I-Lab</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-407') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-407')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-407') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-407') }}</b>
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

        <td class="tc">PHARM-417</td>
        <td>Pharmaceutical Marketing & Management</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-417') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-417')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-417') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-417') }}</b>
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
        <td class="tc">PHARM-408</td>
        <td>Pharmaceutical Engineering</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-408') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-408')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-408') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-408') }}</b>
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

        <td class="tc">PHARM-418</td>
        <td>Pharmaceutical Regulatory Affairs</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-418') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-418')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-418') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-418') }}</b>
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
        <td class="tc">PHARM-409</td>
        <td>Clinical Pharmacy</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'PHARM-409') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'PHARM-409')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'PHARM-409') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'PHARM-409') }}</b>
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

        <td class="tc">PHARM-419</td>
        <td>Project</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-419') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-419')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-419') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-419') }}</b>
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

        <td class="tc">PHARM-420</td>
        <td>In-Plant Training</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'PHARM-420') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'PHARM-420')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'PHARM-420') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'PHARM-420') }}</b>
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

        <td class="tc">VV-411</td>
        <td>Viva-voce</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'VV-411') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'VV-411')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'VV-411') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'VV-411') }}</b>
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

    {{--7 and 8 semester--}}

</table>

@if(!empty($transcript_result))
    <table class="summary_table">
        <tr>
            <th style="text-align: left;border-right: 1px solid #FFFFFF;font-size: 12px">Total Credit Required
                : {{ $transcript_result['total_credit_required'] }}</th>
            @if(!empty($transcript_result['exempted_credit']))
                <th>Credit Exempted : {{ $transcript_result['exempted_credit'] }}</th>
            @endif
            <th style="border-right: 1px solid #FFFFFF;font-size: 12px">Credit Earned
                : {{ $transcript_result['total_credit_earned'] }}</th>
            <th style="border-right: 1px solid #FFFFFF;font-size: 12px">Average Grade
                : {{ $transcript_result['grade_letter'] }}</th>
            <th style="text-align: right;font-size: 12px">CGPA
                : {{ sprintf('%0.2f', $transcript_result['cgpa']) }}</th>
        </tr>
        <tr>
            <th style="text-align: left;border-left: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;border-bottom: 2px solid #FFFFFF;font-size: 12px;padding-top: 10px;padding-left: -1px">
                Result
                Published
                on {{ \Carbon\Carbon::parse($otherStudentForm->result_published_date)->format('d-m-Y') }}
            </th>
            <th style="text-align: center;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;font-size: 12px;padding-top: 10px"
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
                <p><strong>Prepared by</strong> .........................................</p>
            </td>
            <td style="padding: 0.5in 0.2in 0 0.2in;">
                <p><strong>Compared by</strong> ......................................</p>
            </td>
            <td style="padding: 0.5in 0 0 0.2in;">
                <p><strong>Controller of Examinations</strong></p>
            </td>
        </tr>
    </table>
</div>
</body>