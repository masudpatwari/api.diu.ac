<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Provisional Certificate</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 14px !important;
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

        .w-30 {
            width: 30%;
        }

        /*margin*/
        .mt-1 {
            margin-top: 2px;
        }

        .mt-5 {
            margin-top: 10px;
        }

        .pdf_image {
            position: absolute;
            top: 30%;
            left: 28%;
            transform: translate(50%, -50%);
        }

        .p-5 {
            padding-top: 2px;
            padding-bottom: 2px;
        }

    </style>
</head>
<body>

     @php
        $url = '';
        $img = '';
        $decoded = json_decode($student, true);
        try{
            $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $decoded['id'] . ".JPG");
            $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $decoded['id'] . ".JPG";

            // $url = env("APP_URL") . "images/student_profile_photo_" . $student->id . ".jpg";

            if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){
             
                $url = env("APP_URL") . "images/student_profile_photo_" . $decoded['id'] . ".jpg";
            }
        }
        catch (\Exception $exception){
            try{
                
                $url = env("APP_URL") . "images/student_profile_photo_" . $decoded['id'] . ".jpg";
            }
            catch (\Exception $exception){
                $url = "";
            }
        }
        
    @endphp

<table>

    <tr>
        <th class="w-20 b-none" rowspan="5">

             @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode( $img )?>' style="width:130px;"/>
            @else
                <p style="margin-top: 0.5in">Passport size photo</p>
            @endif
            
        </th>

        <th class="bt-none bb-none">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;padding:0 2px;">
        </th>

        <th class="b-none" style="width: 75%">
            <span style="font-size: 23px;text-transform: uppercase;">Dhaka International University
            <br>
                <span style="font-size: 12px;">House # 4, Road # 1, Block - F,
Banani, Dhaka-1213, Bangladesh</span>

            </span>
        </th>
    </tr>

    <tr>
        <th rowspan="4" class="bb-none bl-none br-none"></th>
        <th class="b-none">
            <span style="font-size: 23px;"><i>Application Form for</i></span>
        </th>
    </tr>
    <tr>

        <th class="b-none">
            <span style="font-size: 23px">Provisional Certificate</span>
        </th>
    </tr>

</table>

<div style="width: 100%;" class="mt-5">

    <div style="float: left;width: 49%">
        <table>
            <tr>
                <td class="bb-none">Receipt No ..........................Date: ..................</td>
            </tr>
            <tr>
                <td class="bb-none">Received TK. <b>1000.00</b> (<b>One Thousand</b>) only.</td>
            </tr>

            <tr>
                <td class="bb-none">Note: <b>Student has no dues</b></td>
            </tr>

            <tr>
                <td class="tr bb-none" style="padding-top: 40px;"></td>
            </tr>

            <tr>
                <td class="tr"><span style="border-top: 1px solid #000">Accounts Officer</span></td>
            </tr>
        </table>
    </div>

    <div style="float: left;width: 49%;margin-left: 10px;">
        <table>
        <tr>
            <td class="bb-none">Account Officer may receive TK. <b>1000.00</b> (<b>One Thousand</b>) only</td>
        </tr>
        <tr>
            <td class="bb-none" style="padding-top: 64px;"></td>
        </tr>

        <tr>
            <td class="tr"><span style="border-top: 1px solid #000">Dealing Officer</span></td>
        </tr>
    </table>
    </div>
</div>

<table class="b-none mt-5">
    <tr class="b-none">
        <td class="br-none p-5">1.</td>
        <td colspan="2" class="w-20">Student's Name</td>
        <td class="w-1 bl-none br-none">:</td>
        <td class="br-none" colspan="3"> <b>{{ $decoded['name'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5">2.</td>
        <td colspan="2">Father's Name</td>
        <td class="w-1 bl-none br-none">:</td>
        <td class="br-none" colspan="3"> <b>{{ $decoded['f_name'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5">3.</td>
        <td colspan="2">Mother's Name</td>
        <td class="w-1 bl-none br-none">:</td>
        <td class="br-none" colspan="3"> <b>{{ $decoded['m_name'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5" rowspan="2">4.</td>
        <td rowspan="2" class="w-10 br-none">Address</td>
        <td style="width: 15%">a) Present</td>
        <td class="w-1 bl-none br-none">:</td>
        <td class="br-none" colspan="3"> <b>{{ $decoded['mailing_add'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td>b) Permanent</td>
        <td class="w-1 bl-none br-none">:</td>
        <td colspan="3" class="br-none"> <b>{{ $decoded['parmanent_add'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none">5.</td>
        <td colspan="4" class="br-none">Nationality : <b>{{ $decoded['nationality'] ?? 'N/A' }}</b> </td>
        <td colspan="2" class="br-none">Mobile No : <b>{{ $decoded['phone_no'] ?? 'N/A' }}</b> </td>

    </tr>

    <tr class="b-none">
        <td class="br-none p-5">6.</td>
        <td colspan="6" class="br-none">Name of the Program: <b>{{ $decoded['department']['name'] ?? 'N/A' }}</b> ;  <span style="padding-left: 5px;"></span>Duration of Course (Month): <b>{{ $student_provisional_transcript_marksheet_info['duration_in_month'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5">7.</td>
        <td colspan="4" class="br-none">Subject (Major if any) : <b>{{ $student_provisional_transcript_marksheet_info['batch_name_as_major'] ?? 'N/A' }}</b> </td>
        <td colspan="2" class="br-none">Roll No: <b>{{ $decoded['roll_no'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5">8.</td>
        <td colspan="5" class="br-none">Registration No : <b>{{ $decoded['reg_code'] ?? 'N/A' }}</b> <span style="padding-left: 15px;">Session: <b>{{ $decoded['batch']['sess'] ?? 'N/A' }}</b></span>
        </td>
        <td colspan="2">Batch: <b>{{ $decoded['batch']['batch_name'] ?? 'N/A' }}</b></td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5">9.</td>
        <td colspan="4" class="br-none">Year of Examination : <b>{{ $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'] ?? 'N/A' }}</b> </td>
        <td colspan="2" class="br-none">Result: CGPA / Class : <b>{{ $student_provisional_transcript_marksheet_info['cgpa'] ?? 'N/A' }}</b> </td>
    </tr>

    <tr class="b-none">
        <td class="br-none p-5">10.</td>
        <td colspan="6" class="br-none">Improvement Course No .(if any):

            <table class="b-none">
                <tr>
                    <td class="bb-none" style="font-size: 8px;">
                        a) Incourse: 
                            @if($student_provisional_transcript_marksheet_info['improvement_incourse_course_code']) 
                                <b>{{ $student_provisional_transcript_marksheet_info['improvement_incourse_course_code'] ?? 'N/A' }}</b>
                            @else
                                <b>N/A</b>
                            @endif 
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 8px;">
                        b) Final: 

                        @if($student_provisional_transcript_marksheet_info['improvement_final_course_code']) 
                            <b>{{ $student_provisional_transcript_marksheet_info['improvement_final_course_code'] ?? 'N/A' }}</b>
                        @else
                           <b> N/A</b>
                        @endif 

                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none">11.</td>
        <td colspan="6" class="br-none">Attach one copy passport size photograph duly attested by any Teacher of the
            relevant
        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none"></td>
        <td colspan="6" class="br-none">Department or the Registrar of this University using personal seal containing
            Name,
        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none"></td>
        <td colspan="6" class="br-none">Designation and Department.</td>
    </tr>

    <tr class="b-none">
        <td class="br-none">12.</td>
        <td colspan="6" class="br-none">Photocopy of S.S.C/H.S.C/Diploma and Graduation Certificate to be enclosed along</td>
    </tr>

    <tr class="b-none">
        <td class="br-none"></td>
        <td colspan="6" class="br-none">with this application positively.</td>
    </tr>

    <tr class="b-none">
        <td class="br-none">13.</td>
        <td colspan="6" class="br-none">At the time of submitting Application Form for Transcript/Certificate, the
            students are
        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none"></td>
        <td colspan="6" class="br-none">directed to show their all original transcript/certificate to the relevant
            officer for verification.
        </td>
    </tr>

    <tr class="b-none">
        <td class="br-none">14.</td>
        <td colspan="6" class="br-none">Publishing date of the Result : <b>{{ $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'] ?? 'N/A' }}</b> </td>
    </tr>


    <tr class="b-none">
        <td class="br-none" colspan="6"></td>
        <td colspan="2" class="w-15 tr"></td>
    </tr>

    <tr class="b-none">
        <td class="br-none" colspan="6"></td>
        <td colspan="2" class="w-15 tr"></td>
    </tr>

</table>


<table>
    <tr>
        <td rowspan="2" class="w-50">
            I am certifying that He/She has not holding any book & his/her Library card is permanently deactivated.
        </td>
        <td class="tr bb-none bt-none bb-none br-none">........................................</td>
    </tr>

    <tr>
        <td class="tr bb-none br-none">Signature of the Student</td>
    </tr>

    <tr>

        <td style="padding-top: 50px" class="bt-none">..................................................................</td>
        <td class="tr br-none"></td>
    </tr>


    <tr>
        <td class="bt-none">Signature & Seal (Office of the Librarian)</td>
        <td class="tr bt-none bb-none br-none"></td>
    </tr>

</table>


<table class="b-none mt-1">
    <tr>
        <td rowspan="2" class="w-50 br-none"></td>
        <td class="tr bb-none bt-none bb-none br-none">..................................................................</td>
    </tr>

    <tr>

        <td class="tr bb-none br-none">Controller/Dy.Controller of Examinations</td>
    </tr>
</table>

<table class="mt-5 b-none">
    <tr>
        <td style="border-top: 2px solid #000;font-size: 12px!important;color: red"><Strong
                style="border-bottom: 1px solid #000;">N.B:</Strong>
            No Transcript /Marks Certificate or Provisional Certificate will be issued if any discrepancy is found in
            the Application Form.
        </td>
    </tr>
</table>


<div class="pdf_image">
    <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
</div>

</body>
</html>

