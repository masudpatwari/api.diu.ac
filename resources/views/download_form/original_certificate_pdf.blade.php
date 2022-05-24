<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Original Certificate</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        td,
        th {
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
            padding: 5px 15px !important;
            height: 40px;
            letter-spacing: 1px;
            font-size: 18px;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px;
            color: #fff;
            font-weight: bold;
            background: #000;
            border: none;
        }

        .py-10 {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .pdf_image {
            position: absolute;
            top: 30%;
            left: 28%;
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


    <table class="b-none">

        <tr>
            <th rowspan="5" class="bt-none bb-none br-none">
                @if ($img)
                    <img src='data:image/jpeg;base64,<?= base64_encode($img) ?>' style="width:130px;" />
                @else
                    <p>Passport size photo</p>
                @endif
            </th>

            <th class="b-none" style="width: 80%">
                <span style="font-size: 32px">Dhaka International University</span>
                <p>Administrative Building, House No. 04, Road No. 01, Block - F, Banani, Dhaka - 1213</p>

            </th>


        </tr>

        <tr>
            <th class="tc b-none">
                <img src="{{ storage_path('assets/logo.png') }}" alt="Dhaka International University"
                    style="width: 100px;">
            </th>
        </tr>

        <tr>
            <td class="tc b-none" style="font-size: 23px; font-weight: bold;">Application Form for Original
                Certificate</td>
        </tr>

        {{-- <tr> --}}
        {{-- <td class="tc b-none">Phone : 55040891-7, Fax: +88-02-55040898</td> --}}
        {{-- </tr> --}}

        {{-- <tr> --}}
        {{-- <td class="tc b-none">Form No : <b>{{ $otherStudentForm->id ?? 'N/A' }}</b></td> --}}
        {{-- </tr> --}}


    </table>

    {{-- <table class="b-none mt-1"> --}}
    {{-- <tr> --}}
    {{-- <th class="tc" >General Information</th> --}}
    {{-- </tr> --}}
    {{-- </table> --}}
    <table class="b-none">
        <tr>
            <td class="b-none" style="width: 55%">
                <table style="border: 3px solid">
                    <tr>
                        <td class="py-10 b-none">Receipt No <b>{{$otherStudentForm->receipt_no}}</b> Date: <b>{{$otherStudentForm->bank_payment_date}}</b></td>
                        <td rowspan="2" class=""></td>
                    </tr>

                    <tr>
                        <td class="py-10 b-none">Received TK.
                            {{ $otherStudentForm->total_payable }} only.
                        </td>
                    </tr>

                    <tr>
                        <td class="py-10 b-none">
                            (<b>{{ \App\classes\NumberToWord::numberToWord($otherStudentForm->total_payable) }}</b> &nbsp; taka. only)
                        </td>
                    </tr>
                    <tr>
                        <td class="tr b-none" style="padding-top: 25px; "><span>{{ $otherStudentForm->employee->name ?? 'N/A' }}, {{ $otherStudentForm->employee->relDesignation->name ?? 'N/A' }}</span></td>
                        <td class="b-none"></td>
                    </tr>
                    <tr>
                        <td class="tr b-none"><span
                                style="border-top: 1px solid #000">Accounts Officer</span></td>
                        <td class="b-none"></td>
                    </tr>
                </table>
            </td>
            <td class="b-none tr">
                @if ($url)
                    <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                                ->merge($url, 0.3, true)
                                ->size(150)->errorCorrection('H')
                                ->generate($details)) !!} ">
                @endif
            </td>
        </tr>
    </table>


    <table class="mt-1">
        <tr>
            <td class="w-35" colspan="6">Student's Name <b>{{ $student->name ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-35" colspan="6">Father's Name : <b>{{ $student->f_name ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-35" colspan="6">Mother's Name : <b>{{ $student->m_name ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-35" colspan="6">Present Address <b>{{ $student->mailing_add ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-35" colspan="6">Permanent Address <b>{{ $student->parmanent_add ?? 'N/A' }}</b>
            </td>
        </tr>

        <tr>
            <td class="w-35" colspan="6">Nationality <b>{{ $student->nationality ?? 'N/A' }}</b></td>
        </tr>

        <tr>
            <td class="w-35" colspan="6">Contact No. (Mobile) <b>{{ $student->phone_no ?? 'N/A' }}</b></td>
        </tr>
    </table>

    <table class="b-none mt-1">
        <tr>
            <th class="tc" style="font-size: 14px!important;">Name of the Program/Department: {{ $student->department->name ?? '' }} </th>
        </tr>
    </table>

    <table>

        <tr>
            <td style="width: 25%">Roll No</td>
            <td style="width: 25%">{{ $student->roll_no ?? 'N/A' }}</td>
            <td style="width: 25%">Registration No</td>
            <td style="width: 25%">{{ $student->reg_code ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td style="width: 25%">Batch : Day/Eve</td>
            <td style="width: 25%">{{ array_key_exists('batch_name_as_major', $student_provisional_transcript_marksheet_info) ? $student_provisional_transcript_marksheet_info['batch_name_as_major'] : 'N/A' }}</td>
            <td style="width: 25%">Session</td>
            <td style="width: 25%">{{ $student->batch->sess ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td style="width: 25%">Duration of the Course</td>
            @if (array_key_exists('duration_in_month', $student_provisional_transcript_marksheet_info))
                <td style="width: 25%">
                    {{ $student_provisional_transcript_marksheet_info['duration_in_month'] ?? '' }} (Months)
                </td>
            @else
                <td style="width: 25%">
                    N/A
                </td>
            @endif
            <td style="width: 25%">Passing Year</td>
            @if (array_key_exists('result_publish_date_of_last_semester', $student_provisional_transcript_marksheet_info))
                <td style="width: 25%">
                    {{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('Y') }}
                </td>
            @else
                <td style="width: 25%">
                    N/A
                </td>
            @endif
        </tr>

        <tr>
            <td style="width: 25%">Result (CGPA)</td>
            <td style="width: 25%">{{ array_key_exists('cgpa',$student_provisional_transcript_marksheet_info) ? ($student_provisional_transcript_marksheet_info['cgpa'] ?? 'N/A') : 'N/A' }}</td>
            <td style="width: 25%">Result Pub. Date</td>
            @if(array_key_exists('result_publish_date_of_last_semester',$student_provisional_transcript_marksheet_info))
                <td style="width: 25%">{{ \Carbon\Carbon::parse(str_replace('/', '-', $student_provisional_transcript_marksheet_info['result_publish_date_of_last_semester']))->format('d-m-Y') }}</td>
            @else
                <td style="width: 25%">
                    N/A
                </td>
            @endif
        </tr>


    </table>

    <table class="b-none mt-1">
        <tr>
            <th class="tc" style="font-size: 14px!important;">Name of the Program/Department (For Dual
                Degree):</th>
        </tr>
    </table>

    <table>

        <tr>
            <td style="width: 25%">Roll No</td>
            <td style="width: 25%">{{ $otherStudentFormOriginalCertificateSecondDegree->roll_no ?? 'N/A' }}</td>
            <td style="width: 25%">Registration No</td>
            <td style="width: 25%">{{ $otherStudentFormOriginalCertificateSecondDegree->registration_no ?? 'N/A' }}
            </td>
        </tr>

        <tr>
            <td style="width: 25%">Batch : Day/Eve</td>
            <td style="width: 25%">{{ $otherStudentFormOriginalCertificateSecondDegree->batch ?? 'N/A' }}</td>
            <td style="width: 25%">Session</td>
            <td style="width: 25%">{{ $otherStudentFormOriginalCertificateSecondDegree->session ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td style="width: 25%">Duration of the Course</td>
            <td style="width: 25%">
                {{ $otherStudentFormOriginalCertificateSecondDegree->duration_of_the_course ?? 'N/A' }}</td>
            <td style="width: 25%">Passing Year</td>
            <td style="width: 25%">{{ $otherStudentFormOriginalCertificateSecondDegree->passing_year ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td style="width: 25%">Result (CGPA)</td>
            <td style="width: 25%">{{ $otherStudentFormOriginalCertificateSecondDegree->result ?? 'N/A' }}</td>
            <td style="width: 25%">Result Pub. Date</td>
            <td style="width: 25%">
                {{ $otherStudentFormOriginalCertificateSecondDegree->result_published_date ?? 'N/A' }}</td>
        </tr>


    </table>




    <table class="b-none mt-5">
        <tr>
            <td class="b-none"><i>
                    - Attach one copy passport size photocopy of SSC, HSC, Diploma and Graduation certificate(If
                    withdrawn any) along with this application positively.
                </i></td>
        </tr>
        <tr>
            <td class="b-none"><i>
                    - Provisional Certificate must be surrendered at the time of taking delivery of Original
                    Certificate, in default no original certificate will be issued.
                </i></td>
        </tr>
        <tr>
            <td class="b-none"><i>
                    - At the time of submitting Application Form for Transcript/Certificate, the students are directed
                    to know their all original transcripts/certificate to the relevant officer for verification.
                </i></td>
        </tr>
        <tr>
            <td class="b-none"><i>
                    - As per my knowledge above all information are true. I do hereby agree with any decision of DIU
                    authority regarding my information are wrong.
                </i></td>
        </tr>
    </table>

    <table>
        <tr class="b-none ">
            <td class="br-none pt-30">..................................</td>
            <td class="br-none pt-30">........................................</td>
            <td class="w-40 pt-30">................................................................</td>
        </tr>
        <tr class="b-none">
            <td class="br-none">Signature of the student<br>
                Date:
            </td>
            <td class="br-none">Controller of Exams <br>
                Date:
            </td>
            <td>Chairman / Registrar <br />
                Date:
            </td>
        </tr>
    </table>



    <div class="pdf_image">
        <img src="{{ storage_path('assets/diu_back.png') }}" alt="">
    </div>


</body>

</html>
