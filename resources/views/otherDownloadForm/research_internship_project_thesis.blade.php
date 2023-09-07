<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Research / Internship / Project /Thesis</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 12px !important;
            padding: 0 2px;
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
        .w-1 {
            width: 1%;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-16 {
            width: 16%;
        }

        .w-30 {
            width: 30%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 70%;
        }

        .w-35 {
            width: 35%;
        }

        .w-40 {
            width: 40%;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-2 {
            margin-top: 4px;
        }

        .mt-5 {
            margin-top: 10px;
        }

        .mt-10 {
            margin-top: 20px;
        }

        .pt-15 {
            padding-top: 30px;
        }

        .pt-30 {
            padding-top: 60px;
        }

        .fs-18 {
            font-size: 18px !important;
            padding: 4px 5px;
        }

        .fs-16 {
            font-size: 16px !important;
            padding: 2px 2px;
        }

        .custom-btn {
            padding: 5px 10px!important;
            height: 40px;
            /*letter-spacing: 1px;*/
            font-size: 15px;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px;
            color: #fff;
            font-weight: bold;
            background: #000;
            border: none;
        }

        .py-10{
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .pdf_image {
            position: absolute;
            top: 30%;
            left: 28%;
            transform: translate(50%, -50%);
        }

        .qr_image {
            position: absolute;
            top: 8%;
            right: 1%;
            transform: translate(50%, -50%);
        }

    </style>
</head>
<body>


@php
    $url = '';
    $img = '';


    try {

        $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

        $img = pick_desired_image($url, 'image/jpeg');

        
        if(!$img)
        {
            $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".png";

            $img = pick_desired_image($url, 'image/png');

            if(!$img)
            {
                file_get_contents($url);
            }
        }


    } catch (\Exception $e) {

        try {

            if(@file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG")){
                $img = @file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG");
                $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG";
            }
    
            $img = file_get_contents_ssl($url);
    

            if($img != ''){
                if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){
                    $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";
    
                }
            }

            file_get_contents($url);

        } catch (\Exception $e) {
    
                $url = env("APP_URL") . "images/no_image.jpg";
                $img = @file_get_contents_ssl($url);
            }
        }

       // dd($url, $img);
@endphp


<table>

    <tr class="">
        <td class="w-20 b-none" rowspan="5">

            Form No : <b>{{ $otherStudentForm->id ?? 'N/A' }}</b>

            @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode($img)?>' style="width:100px;"/>
            @else
                <p>Passport size photo</p>
            @endif
        </td>

        <th class="bt-none" style="width: 75%">
            <span style="font-size: 24px;text-transform: uppercase;">Dhaka International University</span> <br>
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;">
        </th>

        <th class=" b-none">

        </th>
    </tr>

    <tr>
        <th class="bt-none br-none br-none">
            <span style="font-size: 15px;">
                @if($student->rel_campus->id == '1')
                    House # 4, Road # 1, Block - F, Banani, Dhaka -1213, Bangladesh
                @elseif($student->rel_campus->id == '2')
                    66 Green Road Dhaka - 1205, Bangladesh
                @elseif($student->rel_campus->id == '3')
                    Shatarkul, Badda, Dhaka-1212. Bangladesh.
                @endif
            </span>
        </th>
        <th rowspan="3" class="bb-none br-none bl-none"></th>
    </tr>

    <tr>
        <th class="bt-none br-none br-none">
            <span style="font-size: 16px;"><i>Department of <b>{{ $student->department->department ?? 'N/A' }}</b> </i></span>
        </th>
    </tr>

    <tr>
        <th class="bt-none bb-none br-none">
            <span class="custom-btn">Form of Research / Internship / Project /Thesis </span>
        </th>
    </tr>

</table>

<table class="b-none mt-2">
    <tr>
        <th class="tc" >General Information</th>
    </tr>
</table>

<table class="mt-1">
    <tr>
        <td class="w-35" colspan="6">Name of the Student : <b>{{ $student->name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="w-35" colspan="6">Father's Name : <b>{{ $student->f_name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td class="w-35" colspan="6">Mother's Name : <b>{{ $student->m_name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td colspan="6">Name of the Program : <b>{{ $student->department->name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td colspan="3">Roll No. : <b>{{ $student->roll_no ?? 'N/A' }}</b></td>
        <td>Batch : <b>{{ $student->batch->batch_name ?? 'N/A' }}</b></td>
        <td colspan="2">Shift : <b>{{ $student->shift->name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td colspan="4">Registration No. : <b>{{ $student->reg_code ?? 'N/A' }}</b></td>
        <td class="w-20" colspan="2">Session : <b>{{ $student->batch->sess ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td colspan="3">Semester: <b>{{ $student->current_semester ?? 'N/A' }}</b></td>
        <td class="w-20" colspan="3">Complete Semester :
            <b>{{ $student_account_info_summary['summary']['nos'] ?? 'N/A' }}</b></td>
    </tr>


    <tr>
        <td colspan="3">Cell : <b>{{ $student->phone_no ?? 'N/A' }}</b></td>
        <td colspan="3">Email : <b>{{ $student->email ?? 'N/A' }}</b></td>
    </tr>

</table>

<table class="b-none mt-1">
    <tr>
        <th class="tc" style="font-size: 14px!important;">Organization and Supervisor</th>
    </tr>
</table>

<table>
    <tr>
        <td class="w-35">Title of the report</td>
        <td style="width:2%">:</td>
        <td colspan="4"> <b>{{ $otherStudentFormResearch->title ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td>Name of the Organization</td>
        <td>:</td>
        <td colspan="4"> <b>{{ $otherStudentFormResearch->organization ?? 'N/A' }}</b> </td>
    </tr>

    <tr>
        <td>Organization Address</td>
        <td>:</td>
        <td colspan="4"> <b>{{ $otherStudentFormResearch->address ?? 'N/A' }}</b> </td>
    </tr>

    <tr>
        <td>Name of the Supervisor</td>
        <td>:</td>
        <td colspan="4"> <b>{{ $otherStudentFormResearch->supervisor ?? 'N/A' }}</b> </td>
    </tr>

    <tr>
        <td>Name of the Co-supervisor (if any)</td>
        <td>:</td>
        <td colspan="4"> <b>{{ $otherStudentFormResearch->co_supervisor ?? 'N/A' }}</b> </td>
    </tr>
</table>

<table class="b-none mt-5">

    <tr>
        <td class="bt-none bl-none bb-none br-none">Write down your interested fields from above list</td>
    </tr>


    @foreach($otherStudentFormResearch->interest_field as $row)
        <tr>
            <td class="bl-none bb-none br-none">

                <b>{{ $loop->iteration }} . {{ $row ?? 'N/A' }}</b>
            </td>
        </tr>
    @endforeach


    <tr>
        <td class="bl-none bb-none br-none">Submission Date: .....................................</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">I declare that I must abide by the rules and regulations of this Research /
            Internship / Project /Thesis
        </td>
    </tr>

</table>

<table class="bl-none bb-none br-none mt-5">
    <tr>
        <td><i><strong>Note: </strong>
                Research / Internship / Project / Thesis works shall be carried out at the beginning of the Final/Last semester. Report must be submitted withing three days after completion of the last semester.
            </i>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td class="bt-none bb-none bl-none br-none pt-15" colspan="2">..........................................</td>

        <td class="bt-none bb-none br-none w-30 pt-15">........................................</td>
    </tr>

    <tr>
        <td colspan="2" class="bl-none bb-none br-none">Authorize / Program Officer</td>
        <td class="bt-none bb-none br-none">Signature of the Student</td>
    </tr>

    <tr>

        <td colspan="2" class="bt-none bl-none bb-none br-none">Date: </td>
        <td class="bt-none bb-none br-none">Date: <b>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
    </tr>
</table>

<table>
    <tr class="b-none ">
        <td class="br-none pt-30">..................................</td>
        <td class="br-none pt-30">........................................</td>
        <td class="w-40 pt-30">....................................................................</td>
    </tr>
    <tr class="b-none">
        <td class="br-none">Supervisor Signature <br>
            Date:
        </td>
        <td class="br-none">Co-supervisor Signature <br>
            Date:
        </td>
        <td>Chairman / Coordinator of the Department <br/>
            Date:
        </td>
    </tr>
</table>

<table>
    <tr>
        <td class="w-50 py-10 bb-none">Receipt No. <b>{{ $otherStudentForm->receipt_no ?? 'N/A' }}</b> Date: <b>{{ \Carbon\Carbon::parse($otherStudentForm->bank_payment_date)->format('d-m-Y') }}</b></td>
        <td rowspan="2" class="bt-none br-none bb-none"></td>
    </tr>

    <tr>
        <td class="py-10 bb-none">Received TK. <b>{{ number_format($otherStudentForm->total_payable ?? '', 2) }}</b> </td>
    </tr>

    <tr>
        <td class="py-10 bb-none" style="text-transform: capitalize">(<b>{{ \App\classes\NumberToWord::numberToWord($otherStudentForm->total_payable) }}</b>)only</td>
        <td class="tr bb-none br-none" ><span style="border-top: 1px dotted #000">Dean / Advisor of the Department </span></td>
    </tr>
    <tr>
        <td class="tr" style="padding-top: 35px;">{{ $otherStudentForm->employee->name ?? 'N/A' }}, {{ $otherStudentForm->employee->relDesignation->name ?? 'N/A' }}</td>
        <td class="bb-none br-none"></td>
    </tr>
</table>

<table class="bl-none bb-none br-none mt-5">
    <tr>
        <td><i><strong>Note: </strong>
                Research / Internship / Project / Thesis works shall be carried out at the beginning of the Final/Last semester. Report must be submitted withing three days after completion of the last semester.
            </i>
        </td>
    </tr>
</table>

<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
</div>


<div class="qr_image">
    <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                        ->merge($url, 0.3, true)
                        ->size(140)->errorCorrection('H')
                        ->generate($details)) !!} ">
</div>


</body>
</html>