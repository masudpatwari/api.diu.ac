<!DOCTYPE html>
<html>

<head>




</head>

<body>
    <div class="content" style="margin-bottom: -10px">

        <table style="width: 100%;font-size:12px">
            <tr>
                <td style="text-align: left">
                    <p style="margin: 0;"><strong>Reference No: &nbsp;</strong>DIU/INF/ADM/{{ $studentInfo['student']['reg_code'] ?? 'NA'}}</p>
                </td>
                <td style="text-align: right">
                    <p style="margin: 0;"><strong>Date:</strong> {{ $studentInfo['date'] ?? 'NA'}}</p>
                </td>
            </tr>
        </table>
        <p style="text-align: center;font-size:20px;font-weight:900;"><span style="border-bottom: 1px solid #000">ADMISSION ACKNOWLEDGEMENT</span></p>

        <div style="line-height:17px">

            
            <p style="margin-bottom: 5px">
                <span style="font-size:12px;">Dear {{ $studentInfo['student']['name'] ?? 'NA'}}</span><br>Congratulation! Your Provisional Admission (Final admission will be made upon verification of all documents and approval. No action required) has been completed. Your following information has been updated/approved into our central database: </p>

                <p style="font-size: 12px;line-height: 20px;margin:0px;padding:0px">
                    <strong>Name:</strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['name'] ?? 'NA'}},</span>&nbsp;
                    <strong>S/O: </strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['f_name'] ?? 'NA'}} & {{ $studentInfo['student']['m_name'] ?? 'NA'}},</span>&nbsp;
                    <strong>Registration No: </strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['reg_code'] ?? 'NA'}},</span>&nbsp;
                    <strong>Roll: </strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['roll_no'] ?? 'NA'}},</span>&nbsp;
                    <strong>Department: </strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['department']['name'] ?? 'NA'}},</span>&nbsp;
                    <strong>Batch: </strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['batch']['batch_name'] ?? 'NA'}},</span>&nbsp;
                    <strong>Mobile Number: </strong> <span style="border-bottom: 1px solid #000;">{{ $studentInfo['student']['phone_no'] ?? 'NA'}},</span>&nbsp;
                    <strong>Email Address: </strong> <span style="border-bottom: 1px solid #000;">{{ $email ?? 'NA'}} &nbsp; (Password: Diu@12345) by that email you enjoy office 365 free .</span>&nbsp;
        
                </p>
        </div>


    </div>
   

   

   

    <div>
        <h4 style="margin-bottom: 0px">Financial Information: </h4>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;font-size: 12px">

            <tr style="">
                <td style="border: 1px solid #000; padding: 2px;text-align:left;width:60%">Admission Fee </td>
                <td style="border: 1px solid #000; padding: 2px;width:12%;text-align:right">{{ $studentInfo['admission_fee'] ?? 'NA'}}/-</td>
                <td style="border: 1px solid #000; padding: 2px;text-align: justify;letter-spacing: 0px" rowspan="9">
                    <p style="font-size:14px;line-height: 20px;">We need 10-25 days to update your results  based scholarship (guarantee & no more action Required). Any reference Scholarship will post after approval from authority (No guarantee that will be approved or not )</p>
                </td>

            <tr style="text-align:right" >
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Tuitions Fee </td>
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['tution_fee'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Scholarship ({{ $studentInfo['scholarship_note']}})</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['scholarship_amount'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">

                @if($studentInfo['amount1_note'] == null)
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Amount Note1</td>
                @else
                <td style="border: 1px solid #000; padding: 2px;text-align:left">{{ $studentInfo['amount1_note'] ?? 'NA'}}</td>
                 @endif

                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['amount1'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">
                @if($studentInfo['amount2_note'] == null)
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Amount Note2</td>
                @else
                <td style="border: 1px solid #000; padding: 2px;text-align:left">{{ $studentInfo['amount2_note'] ?? 'NA'}}</td>
                 @endif
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['amount2'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Total Payable</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['total_payable'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Paid at the time of admission</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['sum_of_admission_fee'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Fee to be paid before every Mid-Term Examination
                </td>
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['payable_mid'] ?? 'NA'}}/-</td>
            </tr>
            <tr style="">
                <td style="border: 1px solid #000; padding: 2px;text-align:left">Fee to be paid before every Final Examination</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:right">{{ $studentInfo['payable_final'] ?? 'NA'}}/-</td>
            </tr>
            </tr>

        </table>

    </div>
    <div style="line-height: 1px;font-size:12px;margin-bottom:-10px">
        <p>Please communicate with them if help required: </p>
        <p><strong>For English Course (Free of Cost):</strong> {{$english->name ?? 'NA'}},&nbsp; {{$english->office_email ?? 'NA'}}, &nbsp;{{$english->personal_phone_no ?? 'NA'}}</p>
        <p><strong>Program Officer (For all Academic Purpose): </strong>{{$program->name ?? 'NA'}},&nbsp; {{$program->office_email ?? 'NA'}}, &nbsp;{{$program->personal_phone_no ?? 'NA'}}</p>
        <p><strong>Chair Person (The last person for all problems): </strong>{{$chair->name ?? 'NA'}},&nbsp; {{$chair->office_email ?? 'NA'}}, &nbsp;{{$chair->personal_phone_no ?? 'NA'}}</p>
    </div>

    @php


    $websiteLink = 'https://students.diu.ac/';
    $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
    ->size(150)
    ->errorCorrection('H')
    ->generate($websiteLink));

    $appLink = 'https://play.google.com/store/apps/details?id=ac.diu.diu_app&pcampaignid=web_share';
    $appQrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
    ->size(150)
    ->errorCorrection('H')
    ->generate($appLink));

    $outlookLink = 'https://play.google.com/store/apps/details?id=com.microsoft.office.outlook';
    $outlookQrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
    ->size(150)
    ->errorCorrection('H')
    ->generate($outlookLink));

    @endphp


    <div style="font-size:12px;line-height:1px;margin-bottom:-10px">
        <p>All details will be available through our Android app or student website by following information:</p>

        <p> <strong>Student Portal Email: </strong>{{ $portal['email'] ?? 'NA'}}</p>
        <p><strong>Student Portal Password:</strong> {{ $portal['password'] ?? 'NA'}}</p>
        <p>We hope you will enjoy learning here at Dhaka International University</p>
    </div>


    <table style="width: 100%; font-size:12px;line-height:20px;margin-bottom:20px">
        <tr style="height: 200px">
            <td style="width: 40%">
                
                    <p >Thanking you </p> <br>
                
                <p>Yours Faithfully</p><br><br><br>
                
                <p>{{$employee->name ?? 'NA'}}</p>
                <p>{{$employee->relDesignation->name ?? 'NA'}} </p>
                <p>{{$employee->office_email ?? 'NA'}}</p>

            </td>


            <td style="width: 20%; text-align: right;">
                @if (!empty($outlookQrCode))
                <div style="display: inline-block;">
                    <img style="height: 100px;" src="data:image/png;base64, {!! $outlookQrCode !!}">
                </div>
                @endif


            </td>
            <td style="width: 20%; text-align: right;">
                @if (!empty($appQrCode))
                <div style="display: inline-block;">
                    <img style="height: 100px;" src="data:image/png;base64, {!! $appQrCode !!}">
                </div>
                @endif


            </td>
            <td style="width: 20%; text-align: right;">
                @if (!empty($qrCode))
                <div style="display: inline-block;">
                    <img style="height: 100px;" src="data:image/png;base64, {!! $qrCode !!}">
                </div>
                @endif

            </td>
        </tr>
    </table>

    <div>
        <strong style="border-bottom: 1px solid #000;">Note:</strong><br>
        <ol style="font-size: 10px">
            <li>Free Services Including Wi-Fi, transport, etc can be stopped by authority without any further notice. </li>
            <li>All fees including admission fees, tuitions fees, etc are non refundable.</li>
            <li>University will not take any responsibility for any financial transaction which is not done by bank (Except Admission Fee). </li>
            <li> Please read it carefully   <a href="https://diu.ac/code-of-conduct" style="color: #000;text-decoration:none">https://diu.ac/code-of-conduct</a></li>
        </ol>

    </div>







</body>

</html>
