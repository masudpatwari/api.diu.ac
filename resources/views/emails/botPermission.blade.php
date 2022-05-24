<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Account Credential</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        * {
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        }

        img {
            max-width: 100%;
        }

        .collapse {
            margin: 0;
            padding: 0;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
        }

        a {
            color: #2BA6CB;
        }

        .btn {
            text-decoration: none;
            color: #FFF;
            background-color: #666;
            padding: 10px 16px;
            font-weight: bold;
            margin-right: 10px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
        }

        p.callout {
            padding: 15px;
            background-color: #ECF8FF;
            margin-bottom: 15px;
        }

        .callout a {
            font-weight: bold;
            color: #2BA6CB;
        }

        table.social {
            /* 	padding:15px; */
            background-color: #ebebeb;
        }

        .social .soc-btn {
            padding: 3px 7px;
            font-size: 12px;
            margin-bottom: 10px;
            text-decoration: none;
            color: #FFF;
            font-weight: bold;
            display: block;
            text-align: center;
        }

        a.fb {
            background-color: #423A3D !important;
        }

        a.tw {
            background-color: #1daced !important;
        }

        a.gp {
            background-color: #DB4A39 !important;
        }

        a.ms {
            background-color: #000 !important;
        }

        .sidebar .soc-btn {
            display: block;
            width: 100%;
        }

        table.head-wrap {
            width: 100%;
        }

        .header.container table td.logo {
            padding: 15px;
        }

        .header.container table td.label {
            padding: 15px;
            padding-left: 0px;
        }

        table.body-wrap {
            width: 100%;
        }

        table.footer-wrap {
            width: 100%;
            clear: both !important;
        }

        .footer-wrap .container td.content p {
            border-top: 1px solid rgb(215, 215, 215);
            padding-top: 15px;
        }

        .footer-wrap .container td.content p {
            font-size: 10px;
            font-weight: bold;

        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            line-height: 1.1;
            margin-bottom: 15px;
            color: #000;
        }

        h1 small, h2 small, h3 small, h4 small, h5 small, h6 small {
            font-size: 60%;
            color: #6f6f6f;
            line-height: 0;
            text-transform: none;
        }

        h1 {
            font-weight: 200;
            font-size: 44px;
        }

        h2 {
            font-weight: 200;
            font-size: 37px;
        }

        h3 {
            font-weight: 500;
            font-size: 27px;
        }

        h4 {
            font-weight: 500;
            font-size: 23px;
        }

        h5 {
            font-weight: 900;
            font-size: 17px;
        }

        h6 {
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
            color: #444;
        }

        .collapse {
            margin: 0 !important;
        }

        p, ul {
            margin-bottom: 10px;
            font-weight: normal;
            font-size: 14px;
            line-height: 1.6;
        }

        p.lead {
            font-size: 17px;
        }

        p.last {
            margin-bottom: 0px;
        }

        ul li {
            margin-left: 5px;
            list-style-position: inside;
        }

        ul.sidebar {
            background: #ebebeb;
            display: block;
            list-style-type: none;
        }

        ul.sidebar li {
            display: block;
            margin: 0;
        }

        ul.sidebar li a {
            text-decoration: none;
            color: #666;
            padding: 10px 16px;
            /* 	font-weight:bold; */
            margin-right: 10px;
            /* 	text-align:center; */
            cursor: pointer;
            border-bottom: 1px solid #777777;
            border-top: 1px solid #FFFFFF;
            display: block;
            margin: 0;
        }

        ul.sidebar li a.last {
            border-bottom-width: 0px;
        }

        ul.sidebar li a h1, ul.sidebar li a h2, ul.sidebar li a h3, ul.sidebar li a h4, ul.sidebar li a h5, ul.sidebar li a h6, ul.sidebar li a p {
            margin-bottom: 0 !important;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important; /* makes it centered */
            clear: both !important;
        }

        .content {
            padding: 15px;
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }

        .content table {
            width: 100%;
        }

        .column {
            width: 300px;
            float: left;
        }

        .column tr td {
            padding: 15px;
        }

        .column-wrap {
            padding: 0 !important;
            margin: 0 auto;
            max-width: 600px !important;
        }

        .column table {
            width: 100%;
        }

        .social .column {
            width: 280px;
            min-width: 279px;
            float: left;
        }

        .clear {
            display: block;
            clear: both;
        }

        @media only screen and (max-width: 600px) {

            a[class="btn"] {
                display: block !important;
                margin-bottom: 10px !important;
                background-image: none !important;
                margin-right: 0 !important;
            }

            div[class="column"] {
                width: auto !important;
                float: none !important;
            }

            table.social div[class="column"] {
                width: auto !important;
            }
        }
    </style>
</head>

<body bgcolor="#fff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- BODY -->
<table class="body-wrap" bgcolor="" style="background: #ddd">
    <tr>
        <td></td>
        <td class="container" align="" bgcolor="#FFFFFF">
            <!-- content -->
            <div class="content">
                <table bgcolor="">

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;">

                        <span>To</span> <br>
                        <span>Chairman/Vice-Chairman/Vice-Chancellor</span> <br>
                        <span>Dhaka International University</span>

                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 12px;">
                        <span>Subject: Seeking permission on IT Support Ticket Number  IST-E-{{ $supportTicket->id ?? '' }} </span>
                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 14px;">
                        <span>Honorable Sir</span>
                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left">
                        <span>I am {{ $employee->name ?? 'N/A' }}, {{ $employee->relDesignation->name ?? 'N/A' }} on
                            behalf of IT-Team looking forward your Permission to access Super User (Superior power of edit)
                            on behalf of Vice-Chancellor for solving following matter reported
                            by {{ $supportTicket->user->name ?? 'N/A' }}, {{ $supportTicket->user->relDesignation->name ?? 'N/A' }} </span>
                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 14px;">
                        <span>Issue Subject: {{ $supportTicket->subject ?? 'N/A' }}</span>
                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;">
                        <span>Issue Purpose: {{ $supportTicket->purpose ?? 'N/A' }}</span> <br>

                        @if(count($supportTicket->supportTicketReplies) > 0)
                            <span>Replies:</span> <br>
                            <span>
                                <ul style="margin-left: 30px;">
                                    @foreach($supportTicket->supportTicketReplies as $row)
                                        <li>{{ $loop->iteration }}. {{ $row->reply_text ?? 'N/A' }} ({{ $row->user->name ?? 'N/A' }})</li>
                                    @endforeach
                                </ul>
                            </span>

                    @endif


                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 14px;">
                        <span>If you wants to give me permission to access the account just click on “Permitted” or if you are not agreed or you wants to do self just click on “Not Permitted”. This is always safe and secured that if you please take over the account and do it self. </span>
                    </p>


                    <p style="text-align: center; margin-top: 15px;">

                        <a
                                href="{{ route('supportTicketAction.getPermission',['token'=>$botData['yesToken']]) }}"
                                target="_blank"
                                title="Permitted"
                                style="padding: 10px 15px; font-family: 'Open Sans', sans-serif; color: #ffffff; font-weight: 600; text-align: center; background-color: green; text-decoration: none; text-transform: uppercase; border: none; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; display: inline-block;">
                            Permitted
                        </a>

                        <a
                                href="{{ route('supportTicketAction.getPermission',['token'=>$botData['noToken']]) }}"
                                target="_blank"
                                title="Not Permitted"
                                style="padding: 10px 15px; font-family: 'Open Sans', sans-serif; color: #ffffff; font-weight: 600; text-align: center; background-color: red; text-decoration: none; text-transform: uppercase; border: none; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; display: inline-block;">
                            Not Permitted
                        </a>


                    </p>


                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 14px;">
                        <span>Thanking you</span>
                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 14px;">
                        <span>Yours Faithfully</span>
                    </p>

                    <p style="max-width: 500px;margin: 0 auto;text-align: left;margin-top: 14px;">
                        <span>{{ $employee->name ?? 'N/A' }}</span> <br>
                        <span>{{ $employee->relDesignation->name ?? 'N/A' }}, {{ $employee->relDepartment->name ?? 'N/A' }}</span> <br>
                        <span>{{ $employee->office_email ?? '' }}</span> <br>
                        <span>{{ $employee->office_phone_no ?? '' }}</span>
                    </p>

                    <br>

                </table>
            </div>
            <!-- /content -->
        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <p>Email send by : <a href="https://it.diu.ac/" target="_blank">IT-Team, DIU</a></p>
                            <p>Copyright © {{ \Carbon\Carbon::now()->format('Y') }} DIU. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /FOOTER -->

</body>
</html>

