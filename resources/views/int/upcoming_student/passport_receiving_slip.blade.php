{{--@php
    $profile = $pdf_data['profile'];
@endphp--}}

        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Passport Receiving Slip</title>

    <style>

        body{
            font-size: 13px;
            line-height: 12px;
            background-color: transparent;
        }
        h1, h2, h3, h4, h5, h6{margin: 2px 0; padding: 0;}

        @page {
            margin-top: 2in;
            margin-bottom: 0.8in;
            margin-left: 1in;
            margin-right: 1in;
        }

        .reference {
            position: absolute;
            top: 12%;
            left: 22%;
            transform: translate(50%, -50%);
        }

        .reference_date {
            position: absolute;
            top: 12%;
            right: 8%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="text-align: center; margin-bottom: 0.2in;">
    <h2 style="margin: 0.1in 0;">Passport Receiving Slip</h2>
    <h3>Dhaka International University</h3>
    <h4>House # 04, Road # 01, Block # F, Banani, Dhaka-1213.</h4>
    <h4>(DIU Copy)</h4>
</div>

<div style="margin-bottom: 0.1in;">
    <p>SL.No.</p>
    <ul style="padding: 0 0 0 0.4in; line-height: 0.25in; list-style: square">
        <li>Name : {{ $foreignStudent->relUser->name ?? 'N/A' }}</li>
        <li>Passport no : {{ $foreignStudent->passport_no ?? 'N/A' }}</li>
        <li>Date of Birth :
            @if($foreignStudent->dob)
                {{ \Carbon\Carbon::parse(str_replace('/', '-', $foreignStudent->dob))->format('d-m-Y') }}
            @else
                N/A
            @endif
        </li>
        <li>Nationality : {{ $foreignStudent->father_nationality ?? 'N/A' }}</li>
        <li>Date of Arrival in Bangladesh :
            @if($foreignStudent->date_of_arrival_bd)
                {{ \Carbon\Carbon::parse(str_replace('/', '-', $foreignStudent->date_of_arrival_bd))->format('d-m-Y') }}
            @else
                N/A
            @endif
        </li>
        <li>Name of the guardian in Bangladesh : {{ $foreignStudent->guardian_name ?? 'N/A' }}</li>
        <li>Authorize person from DIU: <b>Kamal</b> </li>
    </ul>
    <ul style="padding: 0 0 0 0.4in; list-style: none; line-height: 0.25in;">
        <li>Name : <b>Kamal Sarker</b> </li>
        <li>Designation : <b>Assistant Registrar</b></li>
        <li>Cell No : <b>+8801611348346</b> </li>
        <li><strong>Dhaka International University</strong></li>
    </ul>
</div>

<div style="border-bottom: 2px dotted #000;"></div>

<div style="text-align: center; margin-top: 0.2in;">
    <h2 style="margin: 0.1in 0;">Passport Receiving Slip</h2>
    <h3>Dhaka International University</h3>
    <h4>House # 04, Road # 01, Block # F, Banani, Dhaka-1213.</h4>
    <h4>(Student Copy)</h4>
</div>

<div style="margin-bottom: 0.1in;">
    <p>SL.No.</p>
    <ul style="padding: 0 0 0 0.4in; line-height: 0.25in; list-style: square">
        <li>Name : {{ $foreignStudent->relUser->name ?? 'N/A' }}</li>
        <li>Passport no : {{ $foreignStudent->passport_no ?? 'N/A' }}</li>
        <li>Date of Birth :
            @if($foreignStudent->dob)
                {{ \Carbon\Carbon::parse(str_replace('/', '-', $foreignStudent->dob))->format('d-m-Y') }}
            @else
                N/A
            @endif
        </li>
        <li>Nationality : {{ $foreignStudent->father_nationality ?? 'N/A' }}</li>
        <li>Date of Arrival in Bangladesh :
            @if($foreignStudent->date_of_arrival_bd)
                {{ \Carbon\Carbon::parse(str_replace('/', '-', $foreignStudent->date_of_arrival_bd))->format('d-m-Y') }}
            @else
                N/A
            @endif
        </li>
        <li>Name of the guardian in Bangladesh : {{ $foreignStudent->guardian_name ?? 'N/A' }}</li>
        <li>Authorize person from DIU: <b>Kamal</b> </li>
    </ul>
    <ul style="padding: 0 0 0 0.4in; list-style: none; line-height: 0.25in;">
        <li>Name : <b>Kamal Sarker</b> </li>
        <li>Designation : <b>Assistant Registrar</b></li>
        <li>Cell No : <b>+8801611348346</b> </li>
        <li><strong>Dhaka International University</strong></li>
    </ul>
</div>
</body>
</html>
