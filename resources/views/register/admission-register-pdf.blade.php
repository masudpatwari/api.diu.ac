<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->


    <title>Pdf</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        td,
        th {
            border: 1px solid #000 !important;
            padding: 10px;
        }

        .desc {
            font-size: 13px !important;
        }

        .title {
            font-size: 15px !important;
        }
    </style>
</head>

<body>


    <table class="table table-striped  table-bordered">
        <thead>
            <tr>
                <th class="title">Roll</th>
                <th class="title" style="width: 14%">Student, Father & Mother Names</th>
                <th class="title">Registration No</th>
                <th class="title">Student Contact No & Email</th>
                <th class="title">Legal Guardian & Contact No</th>
                <th class="title" style="width:12%">Parmanent Address </th>
                <th class="title" style="width:12%">Mailing Address</th>
                <th class="title">Sex</th>
                <th class="title">Date Of Birth & Nationality</th>
                <th class="title">Admission Date & Admission Fees</th>
                <th class="title">SSC Group & Passing Year & Grade & CGPA</th>
                <th class="title">HSC Group & Passing Year & Grade & CGPA </th>
                <th class="title">Honours Group & Passing Year & Class/Grade & CGPA </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($students['data'] as $index => $student)
                <tr>
                    <td class="desc">{{ $student['roll_no'] ?? 'NA' }} </td>
                    <td>
                        <p class="desc">{{ $student['name'] ?? 'NA' }}, </p>
                        <p class="desc">{{ $student['f_name'] ?? 'NA' }}, </p>
                        <p class="desc">{{ $student['m_name'] ?? 'NA' }} </p>
                    </td>
                    <td class="desc">{{ $student['reg_code'] ?? 'NA' }} </td>
                    <td class="desc">
                        <p>{{ $student['phone_no'] ?? 'NA' }}</p>
                        <p>{{ $student['email'] ?? 'NA' }}</p>
                    </td>
                    <td class="desc">

                        @if (!empty($student['g_name']))
                            <p>{{ $student['g_name'] ?? 'NA' }}</p>
                            <p>{{ $student['g_cellno'] ?? 'NA' }}</p>
                        @else
                            <p>{{ $student['f_name'] ?? 'NA' }}</p>
                            <p>{{ $student['f_cellno'] ?? 'NA' }}</p>
                        @endif
                    </td>
                    <td>
                        @if (!empty($student['parmanent_add']))
                            <p class="desc">{{ $student['parmanent_add'] }}</p>
                        @else
                            <p class="desc">NA</p>
                        @endif

                    </td>
                    <td>
                        @if (!empty($student['mailing_add']))
                            <p class="desc">{{ $student['mailing_add'] }}</p>
                        @else
                            <p class="desc">{{ $student['parmanent_add'] ?? 'NA' }}</p>
                        @endif
                    </td>
                    <td>
                        @if ($student['gender'] == 'M')
                            <p class="desc">Male</p>
                        @elseif($student['gender'] == 'F')
                            <p class="desc">Female</p>
                        @else
                            <p class="desc">NA</p>
                        @endif
                    </td>
                    <td>
                        <p class="desc">{{ date('Y-m-d', strtotime($student['dob'])) ?? 'NA' }} </p>
                        <p class="desc">{{ strtoupper($student['nationality']) ?? 'NA' }} </p>
                    </td>
                    <td>
                        <p class="desc">{{ date('Y-m-d', strtotime($student['adm_date'])) ?? 'NA' }} </p>
                        <p class="desc"><strong></strong> {{ $student['payment']['receipt_no'] }}</p>
                        <p class="desc"><strong>TK:</strong> {{ $student['payment']['amount'] }}</p>
                    </td>
                    <td>
                        <p class="desc">{{ strtoupper($student['e_group1']) ?? 'NA' }} </p>
                        <p class="desc">{{ $student['e_passing_year1'] ?? 'NA' }} </p>
                        <p class="desc">{{ $student['e_ltr_grd_tmark1'] ?? '' }}
                            ({{ $student['e_div_cls_cgpa1'] ?? 'NA' }}) </p>
                    </td>

                    <td>
                        <p class="desc">{{ strtoupper($student['e_group2']) ?? 'NA' }} </p>
                        <p class="desc">{{ $student['e_passing_year2'] ?? 'NA' }} </p>
                        <p class="desc">{{ $student['e_ltr_grd_tmark2'] ?? '' }}
                            ({{ $student['e_div_cls_cgpa2'] ?? 'NA' }}) </p>
                    </td>
                    <td>
                        <p class="desc">{{ strtoupper($student['e_group3']) ?? 'NA' }} </p>
                        <p class="desc">{{ $student['e_passing_year3'] ?? 'NA' }} </p>
                        @if ($student['e_div_cls_cgpa3'])
                            <p class="desc">{{ $student['e_ltr_grd_tmark3'] ?? '' }}
                                ({{ $student['e_div_cls_cgpa3'] ?? 'NA' }}) </p>
                        @endif
                    </td>

                </tr>
            @endforeach
            @for ($i = 0; $i < 10; $i++)
                <tr>
                    <td style="height: 80px"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor




        </tbody>
    </table>







</body>

</html>
