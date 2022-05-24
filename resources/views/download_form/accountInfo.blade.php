<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Info</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 18px!important;
            padding: 1px 2px;
        }

        .bb-1 {
            border-bottom: 1px solid #000;
        }

        .b-none{
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

        .tl {
            text-align: left;
        }

        .tc {
            text-align: center;
        }

        .tr {
            text-align: right;
        }

        /*width*/
        .w-1{
            width: 1%;
        }
        .w-5{
            width: 5%;
        }
        .w-10{
            width: 10%;
        }
        .w-15{
            width: 10%;
        }
        .w-20{
            width: 20%;
        }
        .w-16{
            width: 16%;
        }
        .w-25{
            width: 25%;
        }
        .w-30{
            width: 30%;
        }
        .w-40{
            width: 40%;
        }
        .w-50{
            width: 50%;
        }
        .w-70{
            width: 60%;
        }
        .w-30{
            width: 30%;
        }
        /*margin*/
        .mt-1{
            margin-top: 2px;
        }

        .mt-5{
            margin-top: 10px;
        }

    </style>
</head>
<body>

<h2>{{ $student->NAME ?? '' }}</h2>
<h2>{{ $student }}</h2>

</body>
</html>

