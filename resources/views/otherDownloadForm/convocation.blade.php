<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Convocation</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 11px !important;
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
        .w-10 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-16 {
            width: 22%;
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

        .pdf_image {
            position: absolute;
            top: 40%;
            left: 29%;
            transform: translate(50%, -50%);
        }

        .qr_image {
            position: absolute;
            top: 10%;
            right: 2%;
            transform: translate(50%, -50%);
        }

        .footer {
            position: absolute;
            bottom: 2%;
            left: 6%;
            right: 6%;
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
    <tr>

        <th rowspan="3" class="w-20 b-none" style="padding-left: 0!important">
            Form No : <b>{{ $otherStudentForm->id ?? 'N/A' }}</b> <br>
            @if($img)
                <img src='data:image/jpeg;base64,<?=base64_encode($img)?>' style="width:100px;height:80px"/>
            @else
                <p>Passport size photo</p>
            @endif

        </th>

        <th class="bt-none bb-none" style="width: 5%">
            <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University" style="width: 100px;">
        </th>

        <th class="b-none" style="width: 75%">
            <span style="font-size: 25px">Dhaka International University (DIU) <br>
                <span style="font-size: 14px;">House # 4, Road # 1, Block - F,
Banani, Dhaka-1213, Bangladesh</span>
            </span>
        </th>

    </tr>

    <tr>
        <th rowspan="2" class="bb-none bl-none br-none"></th>
        <th class="b-none" style="padding: 10px 0">
            <span style="font-size: 25px">Registration Form</span>
        </th>
    </tr>

    <tr>
        <th class="b-none">
            <span style="font-size: 25px">... <sup>th</sup>   Convocation</span>
        </th>
    </tr>

</table>


<table class="mt-1">
    <tr>
        <td class="w-30">Student's Name</td>
        <td colspan="2"><b>{{ $student->name ?? 'N/A' }}</b></td>
        <td rowspan="3" class="bt-none br-none"></td>
    </tr>
    <tr>
        <td>Father's Name</td>
        <td colspan="2"><b>{{ $student->f_name ?? 'N/A' }}</b></td>
    </tr>
    <tr>
        <td>Mother's Name</td>
        <td colspan="2"><b>{{ $student->m_name ?? 'N/A' }}</b></td>

    </tr>
    <tr>
        <td>Present Address</td>
        <td colspan="3"><b>{{ $student->mailing_add ?? 'N/A' }}</b></td>
    </tr>
    <tr>
        <td>Permanent Address</td>
        <td colspan="3"><b>{{ $student->parmanent_add ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td>Nationality</td>
        <td colspan="3"><b>{{ $student->nationality ?? 'N/A' }}</b></td>
    </tr>

    <tr>
        <td>Contact No. (Mobile)</td>
        <td><b>{{ $student->phone_no ?? 'N/A' }}</b></td>
        <td colspan="2">E-mail Address : <b>{{ $student->email ?? 'N/A' }}</b></td>

    </tr>
</table>

@if ($otherStudentForm->convocation_first_degree == '1')
    <table class="b-none mt-1">
        <tr style="margin-top: 5px;">
            <td class="b-none w-70">
                Name of the Program/Degree: <b>{{ $student->department->name ?? 'N/A' }}</b>
            </td>

            <td class="b-none w-30">
                @if(array_key_exists('batch_name_as_major',$student_provisional_transcript_marksheet_info))
                    Major in: <b>{{ $student_provisional_transcript_marksheet_info['batch_name_as_major'] }}</b>
                @endif
            </td>
        </tr>
    </table>
    <table class="mt-1">
        <tr>
            <td colspan="4"><b>First Degree</b></td>
        </tr>

        <tr>
            <td class="w-16">Roll No</td>
            <td><b>{{ $student->roll_no ?? 'N/A' }}</b></td>
            <td class="w-16">Registration No.</td>
            <td colspan="3"><b>{{ $student->reg_code ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-16">Batch</td>
            <td><b>{{ $student->batch->batch_name ?? 'N/A' }}</b></td>
            <td class="w-16">Session.</td>
            <td><b>{{ $student->batch->sess ?? 'N/A' }}</b></td>
            <td class="w-20" colspan="2">Group: <b>{{ $student->group->name ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-20">Duration Of The Course</td>
            @if(array_key_exists('duration_in_month',$student_provisional_transcript_marksheet_info))
                <td><b>{{ $student_provisional_transcript_marksheet_info['duration_in_month'] ?? '' }} (Month)</b></td>
            @endif
            <td class="w-16">Shift (First/Second)</td>
            <td><b>{{ $student->shift->name ?? 'N/A' }}</b></td>
            @if(array_key_exists('result_publish_date_of_last_semester',$student_provisional_transcript_marksheet_info))
                <td class="w-20" colspan="2">Passing Year:
                    @if($student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'])
                        <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}</b>
                    @else
                        <b>N/A</b>
                    @endif
                </td>
            @else
                <td class="w-20" colspan="2">Passing Year:
                    <b>N/A</b>
                </td>
            @endif
        </tr>

        <tr>
            <td class="w-16">Result (CGPA)</td>
            <td><b>{{ array_key_exists('cgpa',$student_provisional_transcript_marksheet_info) ? ($student_provisional_transcript_marksheet_info['cgpa'] ?? 'N/A') : 'N/A' }}</b></td>
            <td class="w-16">Result Pub. Date</td>

            @if(array_key_exists('result_publish_date_of_last_semester',$student_provisional_transcript_marksheet_info))
                <td colspan="3">
                    @if($student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'])
                        <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('d-m-Y') }}</b>
                    @else
                        <b>N/A</b>
                    @endif
                </td>
            @else
                <td colspan="3">
                    <b>N/A</b>
                </td>
            @endif
        </tr>
    </table>
@endif

@if ($otherStudentForm->convocation_second_degree == '1')

    <table class="mt-1 b-none">
        <tr>
            <td class="b-none w-70">
                Name of the Program/Degree (For Dual Degree) :

                <b>{{ $otherStudentFormConvocationSecondDegree->program ?? '' }}</b>

            </td>

            <td class="b-none w-30">
                Major in:<b>{{ $otherStudentFormConvocationSecondDegree->major_in ?? '' }}</b>
            </td>
        </tr>
    </table>

    <table class="mt-1">
        <tr>
            <td colspan="4"><b>Second Degree</b></td>
        </tr>
        <tr>
            <td class="w-16">Roll No</td>
            <td><b>{{ $otherStudentFormConvocationSecondDegree->roll_no ?? '' }}</b></td>
            <td class="w-16">Registration No.</td>
            <td colspan="3"><b>{{ $otherStudentFormConvocationSecondDegree->registration_no ?? '' }}</b></td>
        </tr>

        <tr>
            <td class="w-16">Batch</td>
            <td><b>{{ $otherStudentFormConvocationSecondDegree->batch ?? '' }}</b></td>
            <td class="w-16">Session</td>
            <td><b>{{ $otherStudentFormConvocationSecondDegree->student_session ?? '' }}</b></td>
            <td class="w-20" colspan="2">Group: <b>{{ $otherStudentFormConvocationSecondDegree->group ?? '' }}</b></td>
        </tr>

        <tr>
            <td class="w-20">Duration Of The Course</td>
            <td><b>{{ $otherStudentFormConvocationSecondDegree->duration_of_the_course ?? '' }}
                    (Month)</b></td>
            <td class="w-16">Shift (First/Second)</td>
            <td><b>{{ $otherStudentFormConvocationSecondDegree->shift ?? '' }}</b></td>
            <td class="w-20" colspan="2">Passing Year:
                <b>{{ $otherStudentFormConvocationSecondDegree->passing_year ?? '' }}</b></td>
        </tr>

        <tr>
            <td class="w-16">Result (CGPA)</td>
            <td><b>{{ $otherStudentFormConvocationSecondDegree->result ?? '' }}</b></td>
            <td class="w-16">Result Pub. Date</td>
            <td colspan="3">
                <b>{{ \Carbon\Carbon::parse($otherStudentFormConvocationSecondDegree->result_published_date ?? '')->format('d-m-Y') }}</b>
            </td>
        </tr>
    </table>

@endif

<table class="mt-1 b-none">
    <tr>
        <td class="b-none">
            Essential Particulars
        </td>
    </tr>

    <tr>
        <td class="bb-none"> i) 2 Copies of Passport Size Colour Photo with Name,Department,Batch & Roll No written on
            back.
        </td>
    </tr>

    <tr>
        <td class="bb-none"> ii) Photocopies of Provisional Certificate/Transcript to be Verified by the Deputy
            Controller/Joint Controller/Controller of the Examinations of DIU.
        </td>
    </tr>

    <tr>
        <td class="bb-none"> iii) SSC,HSC or Diploma or equivalent & Graduation certificates and transcripts must be
            verified by the authorized officer of DIU.
        </td>
    </tr>


    <tr>
        <td style="padding: 10px 5px" class="bb-none">Registration fee: Tk.6000 (For Single Degree) and TK.8000 (For
            Double Degree).
        </td>
    </tr>

    <tr>
        <td class="bb-none">Declaration: I do hereby agree with any decision of DIU authority regarding convocation. As
            per my knowledge above all information are true. Before taking original certificate, I will surrender
            provisional certificate to the office of the Controller of Examinations.
        </td>
    </tr>
</table>

<table class="b-none" style="margin-top: 45px">
    <tr>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
        <td class="tc b-none"><strong>Authorized Officer</strong></td>
        <td class="tc b-none "><strong>Authorized Officer</strong></td>
        <td rowspan="2" class="tc"><strong>Candidate's Signature <br> & Date</strong></td>
    </tr>

    <tr>
        <td class="tc br-none">Seal & Sign (Accounts Office)</td>
        <td class="tc br-none">Seal & Sign (Controller Office)</td>
        <td class="tc b-none">Seal & Sign (Registrar Office)</td>
    </tr>
</table>


<div class="footer">
    <table class="b-none">
        <tr style="margin-top: 2px;">
            <td class="tc" style="padding: 20px 0">
                ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            </td>
        </tr>
    </table>

    @if($otherStudentForm->convocation_first_degree == '1')
        <div style="width: 100%">

            <div style="width: 79%;float: left;">
                <table>
                    <tr>
                        <td colspan="6"><b>First Degree</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Student's Name</td>
                        <td colspan="4"><b>{{ $student->name ?? 'N/A' }}</b></td>
                    </tr>

                    <tr>
                        <td colspan="2">Name of the Program/Degree:</td>
                        <td colspan="4"><b>{{ $student->department->name ?? 'N/A' }}</b></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="w-20">Roll No. : <b>{{ $student->roll_no ?? 'N/A' }}</b></td>
                        <td>Registration No</td>
                        <td colspan="3"><b>{{ $student->reg_code ?? 'N/A' }}</b></td>
                    </tr>

                    <tr>
                        <td colspan="2">Batch: <b>{{ $student->batch->batch_name ?? 'N/A' }} </b></td>
                        <td colspan="2">Shift: <b>{{ $student->shift->name ?? 'N/A' }} </b></td>
                        <td colspan="2">Session: <b>{{ $student->batch->sess ?? 'N/A' }} </b></td>
                    </tr>

                    <tr>
                        <td colspan="3">Duration of the Course:
                            @if(array_key_exists('duration_in_month',$student_provisional_transcript_marksheet_info))
                                <b>{{ $student_provisional_transcript_marksheet_info['duration_in_month'] ?? '' }}
                                    (Month)
                                </b>
                            @else
                                <b>(Month)
                                </b>
                            @endif
                        </td>
                        <td colspan="3">Passing Year :

                            @if(array_key_exists('duration_in_month',$student_provisional_transcript_marksheet_info))
                                @if($student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester'])
                                    <b>{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }} </b>
                                @else
                                    <b>N/A</b>
                                @endif
                            @else
                                <b>N/A</b>
                            @endif
                            Result (CGPA):

                            @if(array_key_exists('cgpa',$student_provisional_transcript_marksheet_info))
                                <b>{{ $student_provisional_transcript_marksheet_info['cgpa'] ?? 'N/A' }} </b>
                            @else
                                <b>'N/A'</b>
                            @endif

                        </td>

                    </tr>
                </table>
            </div>

            <!-- <div style="width: 1%;float: left;">
                <table>
                    <tr>
                        <td class="bt-none"></td>
                    </tr>
                </table>
            </div> -->

            <div style="width: 20%;float: left;margin-left:10px;">
                <table>
                    <tr>
                        <td class="b-none tc">
                            @if($img)
                                <img src='data:image/jpeg;base64,<?=base64_encode($img)?>'
                                     style="width:100px;height:80px"/>
                            @else
                                <p style="margin-top: 0.5in">Passport size photo</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>


        </div>
    @else
        <div style="width: 100%">

            <div style="width: 79%;float: left;">
                <table>
                    <tr>
                        <td colspan="6"><b>Second Degree</b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Student's Name</td>
                        <td colspan="4"><b>{{ $student->name ?? 'N/A' }}</b></td>
                    </tr>

                    <tr>
                        <td colspan="2">Name of the Program/Degree:</td>
                        <td colspan="4"><b>{{ $otherStudentFormConvocationSecondDegree->program ?? '' }}</b></td>
                    </tr>

                    <tr>
                        <td colspan="2" class="w-20">Roll No. :
                            <b>{{ $otherStudentFormConvocationSecondDegree->roll_no ?? 'N/A' }}</b></td>
                        <td>Registration No</td>
                        <td colspan="3"><b>{{ $otherStudentFormConvocationSecondDegree->registration_no ?? '' }}</b>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">Batch: <b>{{ $otherStudentFormConvocationSecondDegree->batch ?? '' }}</b></td>
                        <td colspan="2">Shift: <b>{{ $otherStudentFormConvocationSecondDegree->shift ?? '' }}</b></td>
                        <td colspan="2">Session:
                            <b>{{ $otherStudentFormConvocationSecondDegree->student_session ?? '' }}</b></td>
                    </tr>

                    <tr>
                        <td colspan="3">Duration of the Course:
                            <b>{{ $otherStudentFormConvocationSecondDegree->duration_of_the_course ?? '' }} (Month) </b>
                        </td>
                        <td colspan="3">Passing Year :

                            <b>{{ \Carbon\Carbon::parse($otherStudentFormConvocationSecondDegree->result_published_date ?? '')->format('Y') }} </b>

                            Result (CGPA):

                            <b>{{ $otherStudentFormConvocationSecondDegree->result ?? '' }}</b>

                        </td>

                    </tr>
                </table>
            </div>

            <!-- <div style="width: 1%;float: left;">
                <table>
                    <tr>
                        <td class="bt-none"></td>
                    </tr>
                </table>
            </div> -->

            <div style="width: 20%;float: left;margin-left:10px;">
                <table>
                    <tr>
                        <td class="b-none tc">
                            @if($img)
                                <img src='data:image/jpeg;base64,<?=base64_encode($img)?>'
                                     style="width:100px;height:80px"/>
                            @else
                                <p style="margin-top: 0.5in">Passport size photo</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>


        </div>
    @endif

    <table class="b-none" style="margin-top: 50px;">
        <tr>
            <td class="tc b-none"><strong>Authorized Officer</strong></td>
            <td class="tc b-none"><strong>Authorized Officer</strong></td>
            <td class="tc b-none"><strong>Authorized Officer</strong></td>
        </tr>
    </table>
</div>


<div class="pdf_image">
    <img src="{{ storage_path('assets/convocation.png') }}" alt="">
</div>

<div class="qr_image">
    <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                        ->merge($url, 0.3, true)
                        ->size(135)->errorCorrection('H')
                        ->generate($details)) !!} ">
</div>

</body>
</html>