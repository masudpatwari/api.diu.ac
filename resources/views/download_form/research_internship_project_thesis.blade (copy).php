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

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-5 {
            margin-top: 10px;
        }
        .mt-10{
            margin-top: 20px;
        }

        .pt-15{
            padding-top: 30px;
        }

        .fs-18{
            font-size: 18px!important;
            padding: 4px 5px;
        }

        .fs-16{
            font-size: 16px!important;
            padding: 2px 2px;
        }

    </style>
</head>
<body>

@php
    $url = '';
    $img = '';

    try{
        $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG");
        $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $student->id . ".JPG";

        // $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

        if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){

            $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";
        }
    }
    catch (\Exception $exception){
        try{

            $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";
        }
        catch (\Exception $exception){
            $url = "";
        }
    }

@endphp

<table>

    <tr class="">
        <th class="w-20 b-none"  rowspan="5">
            @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode( $img )?>' style="width:115px;"/>
            @else
                <p style="margin-top: 0.5in">Passport size photo</p>
            @endif
        </th>

        <th class="bt-none" style="width: 75%">
            <span style="font-size: 23px;text-transform: uppercase;">Dhaka International University</span>
        </th>

        <th class=" b-none">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;">
        </th>
    </tr>

    <tr>
        <th class="bt-none br-none br-none">
            <span style="font-size: 16px;"><i>Department of <b>{{ $student->department->department ?? 'N/A' }}</b> </i></span>
        </th>
        <th rowspan="4" class="bb-none br-none"></th>
    </tr>

    <tr>
        <th class="bt-none bb-none br-none">
            <span style="font-size: 15px">Form of Research / Internship / Project /Thesis </span>
        </th>
    </tr>

</table>

<table class="b-none mt-1">
    <tr>
        <th class="tc" style="font-size: 14px!important;">General Information</th>
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
        <td colspan="4">Name of the Department : <b>{{ $student->department->department ?? 'N/A' }}</b></td>
        <td colspan="2">Student Id : 123456</td>
    </tr>
    <tr>
        <td colspan="3">Roll No. : <b>{{ $student->roll_no ?? 'N/A' }}</b></td>
        <td class="w-20" colspan="3">Batch : <b>{{ $student->batch->batch_name ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td colspan="4">Registration No. : <b>{{ $student->reg_code ?? 'N/A' }}</b> </td>
        <td class="w-20" colspan="2">Session : <b>{{ $student->batch->sess ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td colspan="3">Semester: <b>{{ $student->current_semester ?? 'N/A' }}</b> </td>
        <td class="w-20" colspan="3">Complete Semester : <b>{{ $student_account_info_summary['summary']['nos'] ?? 'N/A' }}</b> </td>
    </tr>


    <tr>
        <td colspan="3">Cell : <b>{{ $student->phone_no ?? 'N/A' }}</b> </td>
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
        <td colspan="4"></td>
    </tr>

    <tr>
        <td>Title of the Research Monograph</td>
        <td>:</td>
        <td colspan="4"></td>
    </tr>

    <tr>
        <td>Name of the Organization</td>
        <td>:</td>
        <td colspan="4"></td>
    </tr>

    <tr>
        <td>Organization Address</td>
        <td>:</td>
        <td colspan="4"></td>
    </tr>

    <tr>
        <td>Name of the Supervisor</td>
        <td>:</td>
        <td colspan="4"></td>
    </tr>

    <tr>
        <td>Name of the Co-supervisor (if any)</td>
        <td>:</td>
        <td colspan="4"></td>
    </tr>
</table>

<table class="mt-1">
    <tr>
        <th class="tl">Civil Engineering</th>
    </tr>
    <tr>
        <td class="bl-none bb-none br-none">Different Fields of Civil Engineering</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">a.Structural Engineering</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">b.Geotechnical Engineering</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">c.Environmental Engineering</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">e.Transportational Engineering</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">Write down your interested fields from above list</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">i.</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">ii.</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">iii.</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">iv.</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">v.</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">Brief outline of the topic:.....................</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">Submission Date:.....................</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">I declare that I must abide by the rules and regulations of this Research / Internship / Project /Thesis</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none" style="padding-top: 10px;">........................................</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">Signature of the Student</td>
    </tr>

    <tr>
        <td class="bl-none bb-none br-none">Date:</td>
    </tr>

</table>

<table >
    <tr>
        <td class="bt-none bb-none bl-none"></td>
        <td class="w-20 tc">Office Use Only</td>
        <td class="bt-none bb-none br-none"></td>
    </tr>
</table>

<table class="mt-1">
    <tr>
        <td class="w-20 b-none">Permission</td>
        <td class="w-1 b-none">:</td>
        <td class="w-15 bt-none bb-none tr">Allowed</td>
        <td></td>
        <td class="w-20 bt-none bb-none tr">Not Allowed</td>
        <td></td>
    </tr>
</table>

<table>
    <tr class="b-none ">
        <td class="br-none pt-15">..................................</td>
        <td class="br-none"></td>
        <td class="tr pt-15">....................................................................</td>
    </tr>
    <tr class="b-none">
        <td class="br-none">Supervisor Signature <br>
            Date:
        </td>
        <td class="br-none"></td>
        <td class="tr">Chairman / Coordinator of the Department <br/>
            Date: 12-12-2020
        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none pt-15">...........................................</td>
        <td class="br-none"></td>
        <td class="tr pt-15">..............................................................</td>
    </tr>

    <tr class="b-none">
        <td class="br-none">Advisor of the Department</td>
        <td class="br-none"></td>
        <td class="tr">Signature of the Chairman of the Dept.</td>
    </tr>

    <tr class="b-none">
        <td colspan="3">
            ------Certificate of the Receipt of the fee Tk. 3,500/= in the office of the Accounts Section---------
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>Receipt No : <strong> .................................</strong>   Date: <strong>.............................</strong> Received TK. <strong>3500</strong> /=only</td>
    </tr>
</table>

<table class="b-none mt-5">
    <tr>
        <td><i><strong>Note:</strong>Official seal and signature (respective officer) must have in application form</i></td>
    </tr>
</table>

<br>

<!--2nd page-->
<table class="b-none">
    <tr>
        <th class="tc bb-none fs-16">Dhaka International University</th>
    </tr>
    <tr>
        <td class="tc bb-none fs-16">Campus: 66 Green Road, Dhaka-1205</td>
    </tr>
    <tr>
        <th class="tc bb-none fs-16">Department of Business Administration</th>
    </tr>

    <tr>
        <th class="tc fs-16">Faculty of Business Studies</th>
    </tr>
</table>

<table class="b-none ">
    <tr class="bb-none">
        <td class="tc bb-none" colspan="3">
            .....................................................................................................................................
        </td>
    </tr>
    <tr>
        <td rowspan="2" colspan="2" class="bt-none bb-none br-none fs-16">Name of the Student (in Cap.):</td>
        <td class="bt-none bb-none br-none fs-16">Date of issue:</td>
    </tr>

    <tr>
{{--        <td colspan="2" class="bb-none br-none fs-16">ss</td>--}}
        <td class="bb-none br-none fs-16">Reg. No:</td>
    </tr>

    <tr>
        <td class="bb-none br-none fs-16">Major Subject of Study:</td>
        <td class="bb-none br-none fs-16">Batch:</td>
        <td class="bb-none fs-16">Roll No.:</td>
    </tr>

    <tr>
        <td colspan="3" class="bt-none fs-16">Name of the Supervisor-Teacher (with designation):</td>
    </tr>
</table>

<table class="b-none mt-5">
    <tr>
        <th style="text-decoration: underline;" class="bb-none fs-16">Internship/Project Proposal Form</th>
    </tr>

    <tr class="bb-none bt-none">
        <td class="bb-none fs-16">Research Topic:</td>
    </tr>

    <tr class="bb-none">
        <td class="tc bb-none fs-16">A.Outline of the Proposal (with a synoptic structure of the report in vision)*</td>
    </tr>

    <tr class="bb-none">
        <td class="tc bb-none">
            .....................................................................................................................................
        </td>
    </tr>

    <tr>
        <td class="bb-none fs-16">i.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">ii.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">iii.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">iv.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">v.</td>
    </tr>

    <tr class="bt-none">
        <td class="fs-16">
            <strong>
                A1.Certificate of the Outline by the Supervisor-Teacher (in writing):
            </strong>
        </td>
    </tr>

</table>

<table class="b-none mt-15">
    <tr class="bb-none" style="margin-top: 25px;">
        <td colspan="3" class="bb-none">..</td>
    </tr>

    <tr>
        <td colspan="2" class="bb-none br-none bt-none">Signature (with date):</td>
        <td class="tc bb-none bt-none">Signature: (with date)</td>
    </tr>

    <tr>
        <td colspan="2" class="bt-none br-none">Supervisor-Teacher:</td>
        <td class="tc">Name of the student:</td>
    </tr>
</table>

<table class="b-none mt-5">

    <tr class="bb-none">
        <td class="tc bb-none">
            .....................................................................................................................................
        </td>
    </tr>

    <tr>
        <th class="bb-none fs-16">Sketch of the Final report to be made</th>
    </tr>

    <tr>
        <th class="bb-none fs-16">(must conform to the prospective contents of the Final Report)</th>
    </tr>

    <tr class="bb-none">
        <td class="tc bb-none">
            .....................................................................................................................................
        </td>
    </tr>

    <tr>
        <td class="bb-none fs-16">a.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">b.</td>
    </tr>

    <tr >
        <td class="bb-none fs-16">c.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">d.</td>
    </tr>

    <tr>
        <td class="bb-none fs-16">e.</td>
    </tr>

    <tr class="bt-none">
        <td class="fs-16">
            <strong>
                B 1.Certificate of the reporting format by the Supervisor-Teacher (in writing):
            </strong>
        </td>
    </tr>

</table>

<table class="b-none mt-15">
    <tr>
        <td colspan="3" class="bb-none">..</td>
    </tr>

    <tr>
        <td colspan="2" class="bt-none bb-none br-none fs-16">Signature (with date):</td>
        <td class="tc bb-none bt-none fs-16">Signature: (with date)</td>
    </tr>

    <tr>
        <td colspan="2" class="bt-none bb-none br-none fs-16">Supervisor-Teacher:</td>
        <td class="tc bb-none fs-16">Name of the student:</td>
    </tr>

    <tr class="bb-none">
        <td colspan="3" class="bb-none bt-none tc">
            .....................................................................................................................................
        </td>
    </tr>

    <tr class="bb-none">
        <td colspan="3" class="bb-none bt-none fs-16">{(Use extra Pages), if necessary.}</td>
    </tr>

    <tr>
        <td class="bb-none bt-none fs-16" colspan="3"><strong>NB:</strong> Without written certification by the Supervisor-Teacher at A1 and B1, no
            forwarding letter will be issued.
        </td>
    </tr>

    <tr>
        <td colspan="3" class="bb-none bt-none fs-16"><strong>For Kind information:</strong></td>
    </tr>

    <tr>
        <td colspan="3" class="bb-none bt-none fs-16">Hon’ble Advisor Sir, Faculty of Business Studies, DIU</td>
    </tr>
</table>



<!--three-->
<table class="b-none" style="font-size: 30px">
    <tr>
        <td class="bb-none fs-18"><strong>Managing Director</strong></td>
    </tr>
    <tr>
        <td class="bb-none fs-18"><strong>First Security Islami Bank Ltd.</strong></td>
    </tr>
    <tr>
        <td class="bb-none fs-18">House- SW(I) 1/A, Road-8, Gulshan-1,</td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Dhaka-1212, Bangladesh</td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15">(Attention: Head of Human Resources Division)</td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15">Subject: Placement of Students as Interns</td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Dear Sir</td>
    </tr>
    <tr>
        <td class="bb-none fs-18">Internship is a formal part of BBA Program of our University. The purpose of this program is to give
            an exposure to our students regarding the happenings of the present day competitive business world.
            We expect that our business students should not only be thinking-managers, they should also be
            action-managers.
        </td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15">
            With this end in view, we have chosen your esteemed organization. We believe practical exposure in
            your organization will widen the window of knowledge of our students.
        </td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15">
            The internship program is of <strong>3(three)-month</strong> duration. Each student will be closely
            supervised by a
            faculty who will provide them guidance
        </td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15">
            Under the above circumstances, may I request your honour to accommodate our student (bearing the
            letter) at the earliest in your esteemed organization as per your convenience.
        </td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15">
            You can rest assured that materials collected will be used for academic exercise only.
        </td>
    </tr>
    <tr>
        <td class="bb-none fs-18 ptb-15"><strong>Particulars of the intern student (with this letter): </strong>
            <table class="b-none w-85" style="margin: 0 15px">
                <tr>
                    <td class="bb-none fs-18">Name: Ms. / Mr. <strong>MD. SHAFIKUL ISLAM</strong>…....…………………………..</td>
                </tr>
                <tr>
                    <td class="fs-18 bb-none">Roll no.: <strong>11</strong>………, Batch: …<strong>46<sup>th</sup> B</strong>……….,Reg. No.:……<strong>243661</strong>………, </td>
                </tr>

                <tr>
                    <td class="fs-18"> Program: <strong>BBA</strong> …... Major in:…………… <strong>FINANCE</strong> ………..….…....</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="fs-18">
        <td class="fs-18 bb-none">Your cooperation is highly solicited.</td>
    </tr>
    <tr class="bb-none fs-18">
        <td class="fs-18">With warm thanks and regards.</td>
    </tr>
</table>

<table class="b-none mt-35">
    <tr>
        <td class="bb-none fs-18"><strong>(Swadrul Wola Choudhury)</strong></td>
    </tr>

    <tr>
        <td class="bb-none fs-18"><strong>Assistant Professor</strong></td>
    </tr>

    <tr>
        <td class="bb-none fs-18"><strong>and</strong></td>
    </tr>

    <tr>
        <td class="bb-none fs-18"><strong>Program Coordinator</strong></td>
    </tr>

    <tr>
        <td class="fs-18"><strong>Department of Business Administration</strong></td>
    </tr>
</table>

</body>
</html>