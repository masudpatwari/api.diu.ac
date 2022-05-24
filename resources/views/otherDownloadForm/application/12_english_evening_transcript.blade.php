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
            font-size: 10px;
            padding: 4.5px 4px;
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
    </style>

</head>
<body>

<table class="header_table">
    <tr>
        <td colspan="3"
            style="padding-bottom: 15px;font-size: 25px;text-transform: uppercase;letter-spacing: 2px;font-weight: bold;padding-left: 135px">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-bottom: 15px;font-size: 23.5px;text-align: center;font-weight: bold;letter-spacing: 1px">Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 25px;text-align: center;font-weight: bold;padding-bottom: 11px">B. A (Hons.) in English
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
        <th style="width: 1%">Course <br> No.</th>
        <th class="tc">Course Title</th>
        <th style="width: 6%">Credit Hours</th>
        <th style="width: 6%">Grade Earned</th>
        <th style="width: 6%">Grade Point</th>

        <th style="width: 1%">Course <br> No.</th>
        <th>Course Title</th>
        <th style="width: 6%">Credit Hours</th>
        <th style="width: 6%">Grade Earned</th>
        <th style="width: 6%">Grade Point</th>
    </tr>
    <tr>
        <td class="tc">101</td>
        <td>Basic English Language-I</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'ENG -101') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'ENG -101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'ENG -101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'ENG -101') }}</b>
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

        <td class="tc">106</td>
        <td>Basic English Language-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'ENG -106') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'ENG -106')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'ENG -106') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'ENG -106') }}</b>
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
        <td class="tc">102</td>
        <td>History of English Literature-I</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'ENG -102') }}</td>
            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'ENG -102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'ENG -102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'ENG -102') }}</b>
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


        <td class="tc">107</td>
        <td>History of English Literature-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'ENG -107') }}</td>

            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'ENG -107')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'ENG -107') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'ENG -107') }}</b>
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
        <td class="tc">103</td>
        <td>History of American Literature-I</td>
        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'ENG -103') }}</td>

            @if($transcript_data[0]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'ENG -103')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'ENG -103') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'ENG -103') }}</b>
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


        <td class="tc">108</td>
        <td>History of American Literature-II</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'ENG -108') }}</td>

            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'ENG -108')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'ENG -108') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'ENG -108') }}</b>
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
        <td class="tc">105</td>
        <td>History of the World</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'ENG -105') }}</td>
            @if($transcript_data[0]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'ENG -105')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'ENG -105') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'ENG -105') }}</b>
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


        <td class="tc">110</td>
        <td>History of English and India</td>
        @if(is_array($transcript_data[1]['allocated_courses']))

            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'ENG -110') }}</td>
            @if($transcript_data[1]['exempted'] == 0)
                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'ENG -110')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'ENG -110') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'ENG -110') }}</b>
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
        <td class="tc">104</td>
        <td>Ancient Western Philosophy</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'ENG -104') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'ENG -104')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'ENG -104') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'ENG -104') }}</b>
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

        <td class="tc">109</td>
        <td>Modern Western Philosophy</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'ENG -109') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'ENG -109')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'ENG -109') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'ENG -109') }}</b>
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
        <td class="tc">201</td>
        <td>Functional English</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'ENG -201') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'ENG -201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'ENG -201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'ENG -201') }}</b>
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

        <td class="tc">203</td>
        <td>Classics in Translation-I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'ENG -203') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'ENG -203')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'ENG -203') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'ENG -203') }}</b>
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
        <td class="tc">202</td>
        <td>Theory of Literature-I</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'ENG -202') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'ENG -202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'ENG -202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'ENG -202') }}</b>
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

        <td class="tc">204</td>
        <td>Anglo-Saxon Poetry</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'ENG -204') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'ENG -204')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'ENG -204') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'ENG -204') }}</b>
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
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>


        <td class="tc">205</td>
        <td style="font-size: 9px">Elizabethan & Restoration Drama-I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'ENG -205') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'ENG -205')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'ENG -205') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'ENG -205') }}</b>
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

    {{--3 and 4 semester--}}


    {{--5 and 6 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">FIFTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">SIXTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">206</td>
        <td>English Writing Skills</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'ENG -206') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'ENG -206')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'ENG -206') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'ENG -206') }}</b>
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

        <td class="tc">209</td>
        <td>Old English Prose</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'ENG -209') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'ENG -209')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'ENG -209') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'ENG -209') }}</b>
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
        <td class="tc">207</td>
        <td>Theory of Literature-II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'ENG -207') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'ENG -207')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'ENG -207') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'ENG -207') }}</b>
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

        <td class="tc">210</td>
        <td style="font-size: 9px">Elizabethan & Restoration Drama-II</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'ENG -210') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'ENG -210')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'ENG -210') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'ENG -210') }}</b>
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
        <td class="tc">208</td>
        <td>Classics in Translation-II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'ENG -208') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'ENG -208')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'ENG -208') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'ENG -208') }}</b>
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

        <td class="tc">301</td>
        <td>Linguistics-I</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'ENG -301') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'ENG -301')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'ENG -301') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'ENG -301') }}</b>
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
        <td class="tc">302</td>
        <td>Poetry from Chaucer to Donne</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'ENG -302') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'ENG -302')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'ENG -302') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'ENG -302') }}</b>
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

        <td class="tc">305</td>
        <td>Victorian Poetry</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'ENG -305') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'ENG -305')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'ENG -305') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'ENG -305') }}</b>
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
        <td class="tc">303</td>
        <td>Romantic Poetry-I</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'ENG -303') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'ENG -303')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'ENG -303') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'ENG -303') }}</b>
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

        <td class="tc">306</td>
        <td>Linguistics-II</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'ENG -306') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'ENG -306')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'ENG -306') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'ENG -306') }}</b>
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
        <td class="tc">304</td>
        <td>Prose from Bacon to Defoe</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'ENG -304') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'ENG -304')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'ENG -304') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'ENG -304') }}</b>
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

        <td class="tc">307</td>
        <td>Poetry from Milton to Pope</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'ENG -307') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'ENG -307')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'ENG -307') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'ENG -307') }}</b>
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

    {{--7 and 8 semester--}}

    {{--9 and 10 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">NINTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">TENTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">308</td>
        <td>Romantic Poetry-II</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'ENG -308') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'ENG -308')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'ENG -308') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'ENG -308') }}</b>
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

        <td class="tc">401</td>
        <td>Contemporary Literary Criticism-I</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'ENG -401') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'ENG -401')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'ENG -401') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'ENG -401') }}</b>
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
        <td class="tc">309</td>
        <td>Prose from Swift to G.Eliot</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'ENG -309') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'ENG -309')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'ENG -309') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'ENG -309') }}</b>
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

        <td class="tc">402</td>
        <td>American Prose</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'ENG -402') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'ENG -402')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'ENG -402') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'ENG -402') }}</b>
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
        <td class="tc">310</td>
        <td>Victorian Novels</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'ENG -310') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'ENG -310')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'ENG -310') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'ENG -310') }}</b>
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

        <td class="tc">403</td>
        <td>American Novels</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'ENG -403') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'ENG -403')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'ENG -403') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'ENG -403') }}</b>
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
        <td class="tc">404</td>
        <td>Third World Literature-I</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'ENG-404') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'ENG-404')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'ENG-404') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'ENG-404') }}</b>
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

        <td class="tc">407</td>
        <td>American Poetry</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'Eng-407') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'Eng-407')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'Eng-407') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'Eng-407') }}</b>
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
        <td class="tc">405</td>
        <td>Comprehensive Test</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'ENG -405') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'ENG -405')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'ENG -405') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'ENG -405') }}</b>
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

        <td class="tc">408</td>
        <td>American Drama</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'Eng-408') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'Eng-408')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'Eng-408') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'Eng-408') }}</b>
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
        <td class="tc">406</td>
        <td style="font-size: 9px">Contemporary Literary Criticism-II</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'ENG -406') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'ENG -406')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'ENG -406') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'ENG -406') }}</b>
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

        <td class="tc">409</td>
        <td>Third World Literature-II</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'Eng-409') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'Eng-409')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'Eng-409') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'Eng-409') }}</b>
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
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>
        <td class="tc">-</td>


        <td class="tc">410</td>
        <td>Third World Literature-II</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'Eng-410') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'Eng-410')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'Eng-410') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'Eng-410') }}</b>
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

    {{--10 and 11 semester--}}

</table>

@if(!empty($transcript_result))
    <table class="summary_table">
        <tr>
            <th style="text-align: left;border-right: 1px solid #FFFFFF;font-size: 14px;padding:10px 5px">Total Credit Required
                : {{ $transcript_result['total_credit_required'] }}</th>
            @if(!empty($transcript_result['exempted_credit']))
                <th>Credit Exempted : {{ $transcript_result['exempted_credit'] }}</th>
            @endif
            <th style="border-right: 1px solid #FFFFFF;font-size: 14px;padding:10px 5px">Credit Earned
                : {{ $transcript_result['total_credit_earned'] }}</th>
            <th style="border-right: 1px solid #FFFFFF;font-size: 14px;padding:10px 5px">Average Grade
                : {{ $transcript_result['grade_letter'] }}</th>
            <th style="text-align: right;font-size: 14px;padding:10px 5px">CGPA
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