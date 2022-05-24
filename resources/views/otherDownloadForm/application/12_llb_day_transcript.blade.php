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
            /*font-size: 10.6px;*/
            /*padding: 1.4px 4px;*/
            font-size: 11.4px;
            padding: .2em .1em;
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
            margin-top: 0.7in;
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
        <td colspan="3"
            style="padding-bottom: 15px;font-size: 23.5px;text-align: center;font-weight: bold;letter-spacing: 1px;">
            Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 22px;text-align: center;font-weight: 650;font-weight: bold">LL.B (Hons.) Examination
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
        <td align="center" valign="middle" style="padding-top: 80px;font-size: 14px;font-weight: bold">
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
        <th style="width: 9%">Course No.</th>
        <th class="tc" style="width: 22%">Course Title</th>
        <th style="width: 6%">Credit Hours</th>
        <th style="width: 7%">Grade Earned</th>
        <th style="width: 6%">Grade Point</th>

        <th style="width: 9%">Course No.</th>
        <th class="tc" style="width: 22%">Course Title</th>
        <th style="width: 6%">Credit Hours</th>
        <th style="width: 7%">Grade Earned</th>
        <th style="width: 6%">Grade Point</th>
    </tr>

    <tr>
        <td class="tc">LL.BH 403</td>
        <td>Muslim Law – I</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'403') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'403')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'403') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'403') }}</b>
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

        <td class="tc">LL.BH 201</td>
        <td>Criminology</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'201') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'201') }}</b>
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
        <td class="tc">LL.BH 102</td>
        <td>Legal System of Bangladesh</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'102') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'102') }}</b>
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

        <td class="tc">LL.BH 202</td>
        <td>Equity and Trust</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'202') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'202') }}</b>
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
        <td class="tc">LL.BH 103</td>
        <td>Roman Law</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'103') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'103')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'103') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'103') }}</b>
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

        <td class="tc">LL.BH 203</td>
        <td>Hindu Law</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'203') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'203')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'203') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'203') }}</b>
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
        <td class="tc">LL.BH 104</td>
        <td>Basic English Language</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'104') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'104')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'104') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'104') }}</b>
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

        <td class="tc">LL.BH 204</td>
        <td>Functional English</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'204') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'204')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'204') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'204') }}</b>
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
        <td class="tc">LL.BH 105</td>
        <td>Introduction to Computer</td>

        @if(is_array($transcript_data[0]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[0]['allocated_courses'],'105') }}</td>

            @if($transcript_data[0]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[0]['allocated_courses'],'105')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[0]['allocated_courses'],'105') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[0]['allocated_courses'],'105') }}</b>
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

        <td class="tc">LL.BH 205</td>
        <td>Database Management System</td>

        @if(is_array($transcript_data[1]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[1]['allocated_courses'],'205') }}</td>

            @if($transcript_data[1]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[1]['allocated_courses'],'205')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[1]['allocated_courses'],'205') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[1]['allocated_courses'],'205') }}</b>
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
        <td class="tc">LL.BH 301</td>
        <td>Law Interpretation & the GCA</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'LL.BH-301') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'LL.BH-301')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'LL.BH-301') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'LL.BH-301') }}</b>
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

        <td class="tc">LL.BH 401</td>
        <td>Law of Transfer of Property I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'401') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'401')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'401') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'401') }}</b>
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
        <td class="tc">LL.BH 302</td>
        <td style="font-size:10px">Law of Contract and Partnership</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'302') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'302')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'302') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'302') }}</b>
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

        <td class="tc">LL.BH 402</td>
        <td>Land Laws of Bangladesh - I</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'402') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'402')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'402') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'402') }}</b>
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
        <td class="tc">LL.BH 303</td>
        <td>Law of Tort</td>

        @if(is_array($transcript_data[2]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[2]['allocated_courses'],'303') }}</td>

            @if($transcript_data[2]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[2]['allocated_courses'],'303')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[2]['allocated_courses'],'303') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[2]['allocated_courses'],'303') }}</b>
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

        <td class="tc">LL.BH 101</td>
        <td>Jurisprudence and Legal Theory</td>

        @if(is_array($transcript_data[3]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[3]['allocated_courses'],'101') }}</td>

            @if($transcript_data[3]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[3]['allocated_courses'],'101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[3]['allocated_courses'],'101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[3]['allocated_courses'],'101') }}</b>
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
        <td class="tc">LL.BH 501</td>
        <td>Law of Transfer of Property II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'501') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'501')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'501') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'501') }}</b>
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

        <td class="tc">LL.BH 601</td>
        <td>PDR Act and Registration Act</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'601') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'601')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'601') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'601') }}</b>
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
        <td class="tc">LL.BH 502</td>
        <td>Land Laws of Bangladesh - II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'502') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'502')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'502') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'502') }}</b>
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

        <td class="tc">LL.BH 602</td>
        <td>Administrative Law</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'602') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'602')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'602') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'602') }}</b>
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
        <td class="tc">LL.BH 503</td>
        <td>Muslim Law - II</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'503') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'503')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'503') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'503') }}</b>
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

        <td class="tc">LL.BH 603</td>
        <td>Constitutional Law II</td>

        @if(is_array($transcript_data[5]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[5]['allocated_courses'],'603') }}</td>

            @if($transcript_data[5]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[5]['allocated_courses'],'603')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[5]['allocated_courses'],'603') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[5]['allocated_courses'],'603') }}</b>
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
        <td class="tc">LL.BH 504</td>
        <td>Constitutional Law I</td>

        @if(is_array($transcript_data[4]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[4]['allocated_courses'],'504') }}</td>

            @if($transcript_data[4]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[4]['allocated_courses'],'504')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[4]['allocated_courses'],'504') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[4]['allocated_courses'],'504') }}</b>
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
        <td class="tc">LL.BH 701</td>
        <td>Law of Evidence - I</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'701') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'701')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'701') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'701') }}</b>
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

        <td class="tc">LL.BH 801</td>
        <td>Law of Evidence - II</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'801') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'801')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'801') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'801') }}</b>
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
        <td class="tc">LL.BH 702</td>
        <td>Law of Criminal Procedure - I</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'702') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'702')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'702') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'702') }}</b>
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

        <td class="tc">LL.BH 802</td>
        <td>Law of Criminal Procedure - II</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'802') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'802')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'802') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'802') }}</b>
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
        <td class="tc">LL.BH 703</td>
        <td>Law of Crimes - I</td>

        @if(is_array($transcript_data[6]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[6]['allocated_courses'],'703') }}</td>

            @if($transcript_data[6]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[6]['allocated_courses'],'703')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[6]['allocated_courses'],'703') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[6]['allocated_courses'],'703') }}</b>
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

        <td class="tc">LL.BH 803</td>
        <td>Law of Crimes - II</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'803') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'803')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'803') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'803') }}</b>
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

        <td class="tc">LL.BH 804</td>
        <td>Fiscal Law</td>

        @if(is_array($transcript_data[7]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[7]['allocated_courses'],'804') }}</td>

            @if($transcript_data[7]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[7]['allocated_courses'],'804')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[7]['allocated_courses'],'804') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[7]['allocated_courses'],'804') }}</b>
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


    {{--9 and 10 semester--}}
    <tr>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">NINTH SEMESTER</th>
        <th colspan="5" class="text-center text-uppercase" style="font-size: 10px;width: 50%;">TENTH SEMESTER</th>
    </tr>

    <tr>
        <td class="tc">LL.BH 901</td>
        <td>Labour and Industrial Law</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'901') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'901')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'901') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'901') }}</b>
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

        <td class="tc">LL.BH 1001</td>
        <td>Law of Civil Procedure - I</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'1001') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'1001')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'1001') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'1001') }}</b>
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
        <td class="tc">LL.BH 902</td>
        <td>Mercantile Law - I</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'902') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'902')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'902') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'902') }}</b>
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

        <td class="tc">LL.BH 1002</td>
        <td>Law  of  Drafting & Pleading <br>(Civil and Criminal)</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'1002') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'1002')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'1002') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'1002') }}</b>
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
        <td class="tc">LL.BH 903</td>
        <td>Company and Banking Law</td>

        @if(is_array($transcript_data[8]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[8]['allocated_courses'],'903') }}</td>

            @if($transcript_data[8]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[8]['allocated_courses'],'903')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[8]['allocated_courses'],'903') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[8]['allocated_courses'],'903') }}</b>
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

        <td class="tc">LL.BH 1003</td>
        <td>Public International Law - I</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'1003') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'1003')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'1003') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'1003') }}</b>
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

        <td class="tc">LL.BH 1004</td>
        <td>Mercantile Law-II</td>

        @if(is_array($transcript_data[9]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[9]['allocated_courses'],'1004') }}</td>

            @if($transcript_data[9]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[9]['allocated_courses'],'1004')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[9]['allocated_courses'],'1004') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[9]['allocated_courses'],'1004') }}</b>
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
        <td class="tc">LL.BH 1101</td>
        <td>Law of Civil Procedure - II</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'1101') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'1101')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'1101') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'1101') }}</b>
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

        <td class="tc">LL.BH 1201</td>
        <td style="font-size: 8px">Law on Dispute Resolution and Legal Aid</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'1201') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'1201')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'1201') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'1201') }}</b>
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
        <td class="tc">LL.BH 1102</td>
        <td>Environmental Laws</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'1102') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'1102')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'1102') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'1102') }}</b>
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

        <td class="tc">LL.BH 1202</td>
        <td style="font-size:9px">Specific Relif Act and Limitation Act</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'1202') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'1202')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'1202') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'1202') }}</b>
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
        <td class="tc">LL.BH 1103</td>
        <td>Public International Law-II</td>

        @if(is_array($transcript_data[10]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[10]['allocated_courses'],'1103') }}</td>

            @if($transcript_data[10]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[10]['allocated_courses'],'1103')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[10]['allocated_courses'],'1103') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[10]['allocated_courses'],'1103') }}</b>
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

        <td class="tc">LL.BH 1203</td>
        <td>Special Criminal Law</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'1203') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'1203')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'1203') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'1203') }}</b>
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

        <td class="tc">LL.BH 1204</td>
        <td>Clinical Legal Education</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'1204') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'1204')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'1204') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'1204') }}</b>
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

        <td class="tc">LL.BH 1205</td>
        <td>Research Monograph</td>

        @if(is_array($transcript_data[11]['allocated_courses']))
            <td class="tc">{{ \App\Libraries\Transcript::creditHour($transcript_data[11]['allocated_courses'],'1205') }}</td>

            @if($transcript_data[11]['exempted'] == 0)

                @if(!empty(\App\Libraries\Transcript::markCheck($transcript_data[11]['allocated_courses'],'1205')))
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradeEarned($transcript_data[11]['allocated_courses'],'1205') }}</b>
                    </td>
                    <td class="tc">
                        <b>{{ \App\Libraries\Transcript::gradePoint($transcript_data[11]['allocated_courses'],'1205') }}</b>
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

    {{--11 and 12 semester--}}

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
                colspan="3">
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