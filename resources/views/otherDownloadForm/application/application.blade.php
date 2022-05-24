<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }}</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 15px !important;
            padding: 0 5px;
        }

        .bb-1 {
            border-bottom: 1px solid #000;
        }

        .b-none {
            border-top: 2px solid #fff;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #fff;
            border-right: 2px solid #fff;
        }

        .bt-none {
            border-top: 2px solid #fff;
        }

        .bb-none {
            border-bottom: 2px solid #fff;
        }

        .br-none {
            border-right: 2px solid #fff;
        }

        .bl-none {
            border-left: 2px solid #fff;
        }


        @page {
            margin-top: 2.5in;
            margin-bottom: 0.8in;
            margin-left: 1in;
            margin-right: 1in;
        }

        .reference {
            position: absolute;
            top: 9.5%;
            left: 20%;
            transform: translate(50%, -50%);
        }

        p {
            text-align: justify;
            font-size: 15px;
        }

        .reference_date {
            position: absolute;
            top: 9.5%;
            right: 8%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>

<p class="reference">{{ $referenceCreate->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

<table class="b-none" style="padding-top: 250px">
    <tr>
        <th style="text-decoration: underline;font-size: 16px"><h1>{{ $title ?? '' }}</h1></th>
    </tr>
</table>

<p>{!! $details !!}</p>

<table class="b-none" style="margin-top: 50px">
    <tr>
        <th class="bb-none" style="text-align: left;">Prof. Md. Rofiqul Islam</th>
    </tr>

    <tr>
        <td class="b-none" style="padding-left: 70px">Registrar</td>
    </tr>

    <tr>
        <td class="b-none">Dhaka International University</td>
    </tr>
</table>

@if ($title == 'English Proficiency Certificate')
    <table class="b-none" style="margin-top: 50px">

        <tr>
            <td class="b-none"><b>Prepared by :</b> .............................................................</td>
        </tr>

        <tr>
            <td class="b-none">(Deputy Registrar)</td>
        </tr>

    </table>
@endif

</body>
</html>