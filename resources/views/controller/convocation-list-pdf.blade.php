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
            padding:  5px;
        }
        .desc{
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
                <th class="title" >R#</th>
                <th class="title"  >Student Name </th>
                <th class="title"  >Phone No</th>
                <th class="title"  >Date</th>
                <th class="title"  >Rac.No</th>
                <th class="title"  >Amount</th>
                <th class="title">Purpose</th>
               
            </tr>
        </thead>
        <tbody>

            @foreach ($students['data'] as $index => $student)
                <tr>
                    @foreach ($student['convocations'] as $index => $con)
                    @if($con['purpose_pay_id'] == 12)
                    <td class="desc">{{ $student['roll_no'] ?? 'NA' }} </td>
                    <td class="desc">{{ $student['name'] ?? 'NA' }} </td>
                    <td class="desc">{{ $student['phone_no'] ?? 'NA' }} </td>
                    
                    <td class="desc">{{ date('Y-m-d', strtotime($con['pay_date'])) ?? 'NA' }} </td>
                    <td class="desc">{{ $con['receipt_no'] ?? 'NA' }} </td>                    
                    <td class="desc"  style="text-align: right">{{ $con['amount'].'/-' ?? 'NA' }} </td>
                    @endif

                    @endforeach
                    <td class="desc" style="text-align: center">
                        @php
                            $hasPurposePayId9 = false;
                            foreach ($student['convocations'] as $index => $con) {
                                if ($con['purpose_pay_id'] == 9  ) {
                                    $hasPurposePayId9 = true;
                                    break;
                                }
                            }
                        @endphp
                       
                        @if ($hasPurposePayId9)
                       
                            PC
                        @else
                            NA
                        @endif
                    </td>

                   

                </tr>
            @endforeach

           


        </tbody>
    </table>







</body>

</html>
