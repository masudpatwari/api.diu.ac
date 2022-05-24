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
            font-size: 10.2px;
            padding: .8px 2px;
        }

        table.summary_table tr th,
        table.summary_table tr td {
            border: 1px solid #000;
            font-size: 8.68px;
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
            margin-top: 0.6in;
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
            style="padding-bottom: 10px;font-size: 25px;text-transform: uppercase;letter-spacing: 2px;font-weight: bold;padding-left: 135px">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-bottom: 10px;font-size: 23.5px;text-align: center;font-weight: bold;letter-spacing: 1px">Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 19px;text-align: center;font-weight: bold">B.Sc. in Computer Science & Engineering
            Examination - {{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}</td>
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


<table class="transcript_table" style="margin-top: 5px">
    {{--1 and 2 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">FIRST SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SECOND SEMESTER</th>
    </tr>
    <tr>
        <th width="0.4in">Course <br> No.</th>
        <th class="tc">Course Title</th>
        <th style="width: 5%">Credit Hours</th>
        <th style="width: 6%">Grade Earned</th>
        <th style="width: 5%">Grade Point</th>

        <th width="0.4in">Course <br> No.</th>
        <th>Course Title</th>
        <th style="width: 5%">Credit Hours</th>
        <th style="width: 6%">Grade Earned</th>
        <th style="width: 5%">Grade Point</th>
    </tr>
    <tr>
        <td class="tc">CSE-101</td>
        <td>Introduction to Computer Systems</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'CSE-101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'CSE-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'CSE-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'CSE-101') }}</b>
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

        <td class="tc">CSE-103</td>
        <td>Structured Programming</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CSE-103') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CSE-103')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CSE-103') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CSE-103') }}</b>
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
        <td class="tc">PHY-101</td>
        <td>Physics-I</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'PHY-101') }}</td>
            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'PHY-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'PHY-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'PHY-101') }}</b>
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


        <td class="tc">CSE-104</td>
        <td>Structured Programming Lab</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'CSE-104') }}</td>

            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'CSE-104')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'CSE-104') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'CSE-104') }}</b>
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
        <td class="tc">GED-101</td>
        <td>Principles of Accounting</td>
        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'GED-101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'GED-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'GED-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'GED-101') }}</b>
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


        <td class="tc">PHY-103</td>
        <td>Physics-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHY-103') }}</td>

            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHY-103')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHY-103') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHY-103') }}</b>
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
        <td class="tc">GED-102</td>
        <td>Bangladesh Studies</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'GED-102') }}</td>
            @if($transcript_data[0]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'GED-102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'GED-102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'GED-102') }}</b>
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


        <td class="tc">PHY-104</td>
        <td>Physics-II Lab</td>
        @if(is_array($transcript_data[1]['allocated_courses']))

            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'PHY-104') }}</td>
            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'PHY-104')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'PHY-104') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'PHY-104') }}</b>
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

        <td class="tc">ENG-101</td>
        <td>Basic English</td>
        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'ENG-101') }}</td>
            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'ENG-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'ENG-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'ENG-101') }}</b>
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

        <td class="tc" style="font-size: 7.5px">MATH-101</td>
        <td style="font-size: 7.5px">Linear Algebra & Co-Ordinate Geometry</td>
        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'MATH-101') }}</td>
            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'MATH-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'MATH-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'MATH-101') }}</b>
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
        <td class="tc">CSE-105</td>
        <td>Digital Systems</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CSE-105') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CSE-105')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CSE-105') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CSE-105') }}</b>
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

        <td class="tc">CSE-201</td>
        <td>Discrete Mathematics</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'CSE-201') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'CSE-201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'CSE-201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'CSE-201') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-106</td>
        <td>Digital Systems Lab</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CSE-106') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CSE-106')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CSE-106') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CSE-106') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">EEE-201</td>
        <td>Electrical Circuits</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'EEE-201') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'EEE-201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'EEE-201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'EEE-201') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CHEM-101</td>
        <td>Chemistry</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CHEM-101') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CHEM-101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CHEM-101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CHEM-101') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">EEE-202</td>
        <td>Electrical Circuits Lab</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'EEE-202') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'EEE-202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'EEE-202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'EEE-202') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CHEM-102</td>
        <td>Chemistry Lab</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'CHEM-102') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'CHEM-102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'CHEM-102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'CHEM-102') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif


        <td class="tc">GED-201</td>
        <td>Principles of Economics</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'GED-201') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'GED-201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'GED-201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'GED-201') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">ENG-102</td>
        <td>Communicative English</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'ENG-102') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'ENG-102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'ENG-102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'ENG-102') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">MATH-201</td>
        <td>Statistical Methods & Probability</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'MATH-201') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'MATH-201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'MATH-201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'MATH-201') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">MATH-102</td>
        <td>Differential & Integral Calculus</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'MATH-102') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'MATH-102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'MATH-102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'MATH-102') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
    </tr>

    {{--3 and 4 semester--}}


    {{--5 and 6 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">FIFTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SIXTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">CSE-203</td>
        <td>Electronic Devices & Circuits</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CSE-203') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CSE-203')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CSE-203') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CSE-203') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-207</td>
        <td>Object Oriented Programming</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'CSE-207') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'CSE-207')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'CSE-207') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'CSE-207') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-204</td>
        <td>Electronic Devices & Circuits Lab</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CSE-204') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CSE-204')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CSE-204') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CSE-204') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-208</td>
        <td>Object Oriented Programming Lab</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'CSE-208') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'CSE-208')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'CSE-208') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'CSE-208') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-205</td>
        <td>Data Structures</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CSE-205') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CSE-205')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CSE-205') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CSE-205') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-209</td>
        <td>Computer Organization & Architecture</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'CSE-209') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'CSE-209')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'CSE-209') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'CSE-209') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-206</td>
        <td>Data Structures Lab</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'CSE-206') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'CSE-206')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'CSE-206') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'CSE-206') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">GED-202</td>
        <td>Principles of Management</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'GED-202') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'GED-202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'GED-202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'GED-202') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">MATH-202</td>
        <td>Differential Equations & Vector Analysis</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'MATH-202') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'MATH-202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'MATH-202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'MATH-202') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">MATH-203</td>
        <td>Complex Variables & Transforms (Laplace & Fourier)</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'MATH-203') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'MATH-203')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'MATH-203') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'MATH-203') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
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
        <td class="tc">CSE-301</td>
        <td>Algorithm Design & Analysis</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CSE-301') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CSE-301')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CSE-301') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CSE-301') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-305</td>
        <td>Microprocessor, Microcontroller & Assembly Language</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CSE-305') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CSE-305')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CSE-305') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CSE-305') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-302</td>
        <td>Algorithm Design & Analysis Lab</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CSE-302') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CSE-302')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CSE-302') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CSE-302') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-306</td>
        <td>Microprocessor, Microcontroller & Assembly Language Lab</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CSE-306') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CSE-306')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CSE-306') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CSE-306') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-303</td>
        <td>Numerical Analysis</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CSE-303') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CSE-303')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CSE-303') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CSE-303') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-307</td>
        <td>Database Management Systems</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CSE-307') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CSE-307')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CSE-307') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CSE-307') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-304</td>
        <td>Numerical Analysis Lab</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CSE-304') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CSE-304')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CSE-304') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CSE-304') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-308</td>
        <td>Database Management Systems Lab</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CSE-308') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CSE-308')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CSE-308') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CSE-308') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">EEE-301</td>
        <td>Data & Telecommunication</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CSE-304') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CSE-304')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CSE-304') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CSE-304') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-313</td>
        <td>System Analysis and Design</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'CSE-313') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'CSE-313')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'CSE-313') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'CSE-313') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">GED-301</td>
        <td>Law & Ethics in Engineering Practice</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'CSE-304') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'CSE-304')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'CSE-304') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'CSE-304') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
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
        <td class="tc">CSE-309</td>
        <td>Operating Systems</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CSE-309') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CSE-309')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CSE-309') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CSE-309') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-401</td>
        <td>Compiler Design</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'CSE-401') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'CSE-401')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'CSE-401') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'CSE-401') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-310</td>
        <td>Operating Systems Lab</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CSE-310') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CSE-310')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CSE-310') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CSE-310') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-402</td>
        <td>Compiler Design Lab</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'CSE-402') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'CSE-402')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'CSE-402') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'CSE-402') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-311</td>
        <td>Computer Networks</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CSE-311') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CSE-311')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CSE-311') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CSE-311') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-403</td>
        <td>Peripherals and Interfacing</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'CSE-403') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'CSE-403')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'CSE-403') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'CSE-403') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-312</td>
        <td>Computer Networks Lab</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CSE-312') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CSE-312')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CSE-312') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CSE-312') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-404</td>
        <td>Peripherals and Interfacing Lab</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'CSE-404') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'CSE-404')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'CSE-404') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'CSE-404') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-315</td>
        <td>Theory of Computing</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CSE-315') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CSE-315')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CSE-315') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CSE-315') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-409</td>
        <td>E-Commerce and Web Engineering</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'CSE-409') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'CSE-409')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'CSE-409') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'CSE-409') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc">CSE-317</td>
        <td>Software Engineering</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'CSE-317') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'CSE-317')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'CSE-317') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'CSE-317') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-410</td>
        <td>E-Commerce & Web Engineering Lab</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'CSE-410') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'CSE-410')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'CSE-410') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'CSE-410') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
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
        <td class="tc">CSE-405</td>
        <td>Computer Graphics & Multimedia</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'CSE-405') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'CSE-405')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'CSE-405') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'CSE-405') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-419</td>
        <td>Image Processing</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'CSE-419') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'CSE-419')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'CSE-419') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'CSE-419') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc" style="font-size: 8px">CSE-406</td>
        <td style="font-size: 8px">Computer Graphics & Multimedia Lab</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'CSE-406') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'CSE-406')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'CSE-406') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'CSE-406') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-420</td>
        <td>Image Processing Lab</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'CSE-420') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'CSE-420')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'CSE-420') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'CSE-420') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc" style="font-size: 7.5px">CSE-407</td>
        <td style="font-size: 7.5px">Artificial Intelligence & Neural Networks</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'CSE-407') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'CSE-407')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'CSE-407') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'CSE-407') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">CSE-425</td>
        <td>Project Work</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'CSE-425') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'CSE-425')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'CSE-425') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'CSE-425') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif
    </tr>

    <tr>
        <td class="tc" style="font-size: 7.5px">CSE-408</td>
        <td style="font-size: 7.5px">Artificial Intelligence & Neural Networks Lab</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'CSE-408') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'CSE-408')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'CSE-408') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'CSE-408') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
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
        <td class="tc">CSE-411</td>
        <td>Parallel and Distributed Processing</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'CSE-411') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'CSE-411')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'CSE-411') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'CSE-411') }}</b>
                    </td>
                @else
                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                @endif
            @else
                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
            @endif
        @else
            <td colspan="3" style="text-align: center;font-size: 8px;">3 or Marks not
                exists
            </td>
        @endif

        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
    </tr>
    {{--10 and 11 semester--}}

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
            <th style="text-align: left;border-left: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;border-bottom: 2px solid #FFFFFF;font-size: 12px;padding-top: 15px;padding-left: -1px">
                Result
                Published
                on {{ \Carbon\Carbon::parse($otherStudentForm->result_published_date)->format('d-m-Y') }}
            </th>
            <th style="text-align: center;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;font-size: 12px;padding-top: 15px"
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
</body>