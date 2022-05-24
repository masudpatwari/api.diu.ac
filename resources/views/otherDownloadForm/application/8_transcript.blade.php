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
            padding: 0.2em;
            border: 1px solid #000;
            font-size: 0.45em;
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
            font-size: 8px;
            padding: .2em .2em;
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
            margin-top: 0.6in;
            margin-left: 0.2in;
            margin-right: 0.2in;
        }
    </style>

</head>
<body>

<table class="header_table">
    <tr>
        <td colspan="3"
            style="padding-bottom: 13px;font-size: 23px;text-align:center;text-transform: uppercase;letter-spacing: 2px;font-weight: bold">
            Dhaka International University
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding-bottom: 13px;font-size: 21px;text-align: center;font-weight: bold;">Transcript of
            Academic Records
        </td>
    </tr>

    <tr>
        <td colspan="3"
            style="font-size: 20px;text-align: center;font-weight: bold;">Bachelor of Pharmacy (Hons.)
            Examination - {{ \Carbon\Carbon::now()->format('Y') }}</td>
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
            Name : {{ $student_info['name'] }}
        </td>
        <td align="right" width="2.2in">
            <table class="std_info" style="border: 1px solid #000000">
                <tr>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;">Issue No.</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;">Date</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;">Roll No.</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;"><b>{{ $student_info['roll_no'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;">Regn. No.</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;"><b>{{ $student_info['reg_code'] }}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left;">Session</td>
                    <td style="padding: 6px 0">:</td>
                    <td></td>
                    <td style="padding: 6px 0;text-align: left"><b>{{ $student_info['session_name'] }}</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>


@if(!empty($transcript_data['semesters']))
    <table class="transcript_table" style="margin-top: 5px">
        @php
            $count = 0;
        @endphp
        @foreach ($transcript_data['semesters'] as $transcript_data_key => $transcript_data_value)
            @php
                $row_1 = @$transcript_data_value[0]['allocated_courses'];
                $row_2 = @$transcript_data_value[1]['allocated_courses'];
                $max = max( (int) @count( $row_1) , (int) @count($row_2) );
            @endphp
            <tr>
                <th colspan="5" class="text-center text-uppercase" style="font-size: 10px">
                    {{ \App\Libraries\EnglishAlphabeticNumber::number($transcript_data_value[0]['semester']) }}
                    SEMESTER
                </th>
                <th colspan="5"
                    class="text-center text-uppercase" style="font-size: 10px">
                    @if(!empty($transcript_data_value[1]))
                        {{ \App\Libraries\EnglishAlphabeticNumber::number($transcript_data_value[1]['semester']) }}
                        SEMESTER
                    @endif</th>
            </tr>
            <tr>
                @if($transcript_data_key == 0)
                    <th width="0.4in">Course No.</th>
                    <th>Course Title</th>
                    <th style="width: 5%">Credit Hours</th>
                    <th style="width: 5%">Grade Earned</th>
                    <th style="width: 5%">Grade Point</th>
                    @if(!empty($transcript_data_value[1]))
                        <th width="0.4in">Course No.</th>
                        <th>Course Title</th>
                        <th style="width: 5%">Credit Hours</th>
                        <th style="width: 5%">Grade Earned</th>
                        <th style="width: 5%">Grade Point</th>
                    @else
                        <th colspan="5"></th>
                    @endif
                @endif
            </tr>

            @php
                $count++;
            @endphp

            @for($i = 0; $i < $max; $i++ )
                <tr>
                    @if(is_array($row_1))
                        {{-- for Right column  --}}
                        @if( @$row_1[$i]['code'])
                            <td style="text-align: center">{{ $row_1[$i]['code'] }}</td>
                            <td>{{ $row_1[$i]['name'] }}</td>
                            <td style="width: 0.2in; text-align: center;">{{ $row_1[$i]['credit'] }}</td>
                            @if($transcript_data_value[0]['exempted'] == 0)
                                @if(!empty($row_1[$i]['marks']['course_total']))
                                    <td style="width: 0.2in; text-align: center;font-weight: bold;">{{ $row_1[$i]['marks']['letter_grade'] }}</td>
                                    <td style="width: 0.2in; text-align: center;font-weight: bold;">{{ sprintf('%0.2f', $row_1[$i]['marks']['grade_point']) }}</td>
                                @else
                                    <td colspan="2" style="text-align: center;font-weight: bold;">Incomplete</td>
                                @endif
                            @else
                                <td colspan="2" style="text-align: center;font-weight: bold;">Exempted</td>
                            @endif
                        @else
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        @endif
                    @else
                        <td colspan="5" style="text-align: center;">{{ $row_1 }}</td>
                    @endif

                    @if(is_array($row_2))
                        {{-- for Left column  --}}
                        @if( @$row_2[$i]['code'])
                            <td style="text-align: center">{{ $row_2[$i]['code'] }}</td>
                            <td>{{ $row_2[$i]['name'] }}</td>
                            <td style="width: 0.2in; text-align: center;">{{ $row_2[$i]['credit'] }}</td>
                            @if($transcript_data_value[1]['exempted'] == 0)
                                @if(!empty($row_2[$i]['marks']['course_total']))
                                    <td style="width: 0.2in; text-align: center;font-weight: bold">{{ $row_2[$i]['marks']['letter_grade'] }}</td>
                                    <td style="width: 0.2in; text-align: center;font-weight: bold">{{ sprintf('%0.2f', @$row_2[$i]['marks']['grade_point']) }}</td>
                                @else
                                    <td colspan="2" style="text-align: center;font-weight: bold">Incomplete</td>
                                @endif
                            @else
                                <td colspan="2" style="text-align: center;font-weight: bold">Exempted</td>
                            @endif
                        @else
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        @endif
                    @else
                        <td colspan="5" style="text-align: center;">{{ $row_2 }}</td>
                    @endif
                </tr>
            @endfor
        @endforeach
    </table>

    <table class="summary_table">
        <tr>
            <th style="text-align: left;border-right: 1px solid #FFFFFF;font-size: 11px">Total Credit Required
                : {{ $transcript_data['results']['total_credit_required'] }}</th>
            @if(!empty($transcript_data['results']['exempted_credit']))
                <th>Credit Exempted : {{ $transcript_data['results']['exempted_credit'] }}</th>
            @endif
            <th style="border-right: 1px solid #FFFFFF;font-size: 11px">Credit Earned
                : {{ $transcript_data['results']['total_credit_earned'] }}</th>
            <th style="border-right: 1px solid #FFFFFF;font-size: 11px">Average Grade
                : {{ $transcript_data['results']['grade_letter'] }}</th>
            <th style="text-align: right;font-size: 11px">CGPA
                : {{ sprintf('%0.2f', $transcript_data['results']['cgpa']) }}</th>
        </tr>
        <tr>
            <th style="text-align: left;border-left: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;border-bottom: 2px solid #FFFFFF;font-size: 11px">
                Result
                Published
                on {{ $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'] ?? '' }}
            </th>
            <th style="text-align: center;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #FFFFFF;border-right: 1px solid #FFFFFF;font-size: 11px"
                colspan="3"></th>
        </tr>
    </table>
@endif


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
</body>