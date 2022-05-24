<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, td, th {
            border: 1px solid #000;
            font-size: 14px !important;
            padding: 1px 2px;
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

        .bb-none {
            border-bottom: 2px solid #fff;
        }

        .bt-none {
            border-top: 2px solid #fff;
        }

        .br-none {
            border-right: 2px solid #fff;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-30 {
            margin-top: 30px;
        }

        .mt-100 {
            margin-top: 100px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        .text-decoration {
            text-decoration: underline;
        }

        .text-center {
            text-align: center;
        }

        .mt-75 {
            margin-top: 65px;
        }

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

@php
    $class_str_date_week =  \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->class_str_date))->weekOfMonth;
    $last_date_of_adm_week = \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->last_date_of_adm))->weekOfMonth;
    $admission_start_date_week =  \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->admission_start_date))->weekOfMonth;

    $class_str_date_total_week =  ceil(date("t", strtotime(\Carbon\Carbon::parse(str_replace('/', '-', $batch_details->class_str_date))->format('Y-m-d'))) / 7);
    $last_date_of_adm_date_total_week =  ceil(date("t", strtotime(\Carbon\Carbon::parse(str_replace('/', '-', $batch_details->last_date_of_adm))->format('Y-m-d'))) / 7);
    $admission_start_date_total_week =  ceil(date("t", strtotime(\Carbon\Carbon::parse(str_replace('/', '-', $batch_details->admission_start_date))->format('Y-m-d'))) / 7);
@endphp

<table class="b-none">
    <tr>
        <td class="bb-none">{{ $foreignStudent->relUser->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td class="bb-none">Date of birth
            - @if($foreignStudent->dob){{ \Carbon\Carbon::parse(str_replace('/', '-', $foreignStudent->dob))->format('d F Y') }} @else
                N/A @endif</td>
    </tr>

    <tr>
        <td class="bb-none">Passport no-{{ $foreignStudent->passport_no ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td class="bb-none">{{ $foreignStudent->father_nationality ?? 'N/A' }}</td>
    </tr>

    <tr>
        <td class="bb-none">Subject: Letter of admission</td>
    </tr>
</table>

<table class="b-none mt-10">
    <tr>
        <td class="bb-none">Dear {{ $foreignStudent->relUser->name ?? 'N/A' }},</td>
    </tr>
    <tr>
        <td class="bb-none">
            I glad to inform you that your application seeking admission
            in {{ $batch_details->rel_department->name ?? 'N/A' }} , ({{ $program->duration ?? 'N/A' }}) has been
            initially
            accepted by the concerned authority of Dhaka International University (DIU), Dhaka, Bangladesh. Your
            enrollment
            will be confirmed upon receiving the main copies of your all academic document and payment of admission and
            other fee which amounts $1000.00 But total tuition fee is approximately
            ${{ number_format(($program->total_fee / 87 ), 2) }} . You will be given a
            Scholarship. You may deposit the following bank account in favor of ‘’Dhaka International University.”
        </td>
    </tr>
</table>

<table class="b-none mt-10">
    <tr>
        <td class="bb-none">Export Import Bank Bangladesh ltd.</td>
    </tr>
    <tr>
        <td class="bb-none">Banani Branch, Dhaka -Bangladesh.</td>
    </tr>
    <tr>
        <td class="bb-none">Account No: 06113100002042</td>
    </tr>
    <tr>
        <td class="bb-none">Swift Code: EXBKBDDH</td>
    </tr>
</table>

<table class="b-none">
    <tr>
        <td class="bb-none">The admission has already started in the

            @if($batch_details->admission_start_date)

                @if($admission_start_date_week == 1)
                    {{ $admission_start_date_week }} <sup>st</sup>
                @elseif($admission_start_date_week == 2)
                    {{ $admission_start_date_week }} <sup>nd</sup>
                @elseif($admission_start_date_week == 3)
                    {{ $admission_start_date_week }} <sup>rd</sup>
                @elseif($admission_start_date_week == 4)

                    @if($admission_start_date_total_week == $admission_start_date_week)
                        last
                    @else
                        <sup>th</sup>
                    @endif

                @elseif($admission_start_date_week == 5)

                    @if($admission_start_date_total_week == $admission_start_date_week)
                        last
                    @else
                        <sup>th</sup>
                    @endif
                @endif
                week
                of {{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->admission_start_date))->format('F') }}
                ,{{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->admission_start_date))->format('Y') }}
            @else
                N/A
            @endif


            and the class will be
            started on

            @if($class_str_date_week == 1)
                {{ $class_str_date_week }} <sup>st</sup>
            @elseif($class_str_date_week == 2)
                {{ $class_str_date_week }} <sup>nd</sup>
            @elseif($class_str_date_week == 3)
                {{ $class_str_date_week }} <sup>rd</sup>
            @elseif($class_str_date_week == 4)

                @if($class_str_date_total_week == $class_str_date_week)
                    last
                @else
                    <sup>th</sup>
                @endif

            @elseif($class_str_date_week == 5)

                @if($class_str_date_total_week == $class_str_date_week)
                    last
                @else
                    <sup>th</sup>
                @endif
            @endif

            week of {{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->class_str_date))->format('F') }}
            ,{{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->class_str_date))->format('Y') }}

            . Hence you are requested to proceed for visa and report in time to complete all required
            official formalities in this regards.
        </td>
    </tr>

    <tr>
        <td class="bb-none">Please feel free to write me if you have any confusion regarding the above mentioned
            information. DIU will
            provide you the necessary initial support in different official issues.
        </td>
    </tr>
    <tr>
        <td class="bb-none">Wish you a bright career ahead in DIU.</td>
    </tr>
    <tr>
        <td class="bb-none pt-10 bt-none">With best regards,</td>
    </tr>
</table>

<table class="mt-30 b-none">
    <tr>
        <td class="bb-none">Professor Md. Shah Alam Chowdhury</td>
    </tr>
    <tr>
        <td class="bb-none">Additional Registrar</td>
    </tr>
    <tr>
        <td class="bb-none bt-none">Dhaka International University</td>
    </tr>
    <tr>
        <td class="bb-none bt-none">House no-4, Road no-01, Block-F</td>
    </tr>
    <tr>
        <td class="bb-none bt-none">Banani , Dhaka Bangladesh.</td>
    </tr>
    <tr>
        <td class="bb-none">Cell: +88-01716559369, 01611348346,</td>
    </tr>
    <tr>
        <td class="bb-none">E-mail: dhakaintluniversity@gmail.com / shahjabeen2010@gmail.com</td>
    </tr>
    <tr>
        <td class="pt-10">Attachment: Rule for admission and registration for foreigners.</td>
    </tr>
</table>


<pagebreak>


    <p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
    <p class="reference_date">{{ $doc->date ?? '' }}</p>

    <table class="b-none">
        <tr class="bb-none">
            <td class="bb-none text-center"><span class="text-decoration"><h2>Rules for Admission and Registration (Foreigner)</h2></span>
            </td>
        </tr>
        <tr>
            <td class="bb-none">The student is requested to note and follow the instructions given below:</td>
        </tr>
    </table>

    <table class="b-none">
        <tr>
            <td class="br-none bb-none">01.</td>
            <td class="bb-none">Program of study: {{ $batch_details->rel_department->name ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td class="br-none bb-none">02.</td>
            <td class="bb-none">Required Credit Hours: {{ $program->credit }}</td>
        </tr>

        <tr>
            <td class="br-none bb-none">03.</td>
            <td class="bb-none">Last date of admission:

                @if($last_date_of_adm_week == 1)
                    {{ $last_date_of_adm_week }} <sup>st</sup>
                @elseif($last_date_of_adm_week == 2)
                    {{ $last_date_of_adm_week }} <sup>nd</sup>
                @elseif($last_date_of_adm_week == 3)
                    {{ $last_date_of_adm_week }} <sup>rd</sup>
                @elseif($last_date_of_adm_week == 4)
                    @if($last_date_of_adm_date_total_week == $last_date_of_adm_week)
                        last
                    @else
                        <sup>th</sup>
                    @endif
                @elseif($last_date_of_adm_week == 5)
                    @if($last_date_of_adm_date_total_week == $last_date_of_adm_week)
                        last
                    @else
                        <sup>th</sup>
                    @endif
                @endif

                week
                of {{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->last_date_of_adm))->format('F') }}
                ,{{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->last_date_of_adm))->format('Y') }}

                (Probably).
            </td>
        </tr>

        <tr>
            <td class="br-none bb-none">04.</td>
            <td class="bb-none">Submission of related documents:</td>
        </tr>

        <tr>
            <td class="br-none bb-none" rowspan="2"></td>
            <td class="bb-none">a) Original and translated copies in English (in case the original certificate is not in
                English)
                of all Certificates & Academic transcripts and other related documents.
            </td>
        </tr>


        <tr>
            <td class="bb-none">b) 7 passport size photographs.</td>
        </tr>


        <tr>
            <td class="br-none bb-none">05.</td>
            <td class="bb-none">Total fees and charges: {{ number_format($program->total_fee,2) }} BDT/-(including
                admission
                and tuition
                fee-payable
            </td>
        </tr>


        <tr>
            <td class="br-none bb-none"></td>
            <td class="bb-none">trimester wise with installment as per foreigner student’s fee structure. In case of
                repeating and improvement of any course
                extra charge will be imposed as per rules).Fees and charges may be changed.
            </td>
        </tr>


        <tr>
            <td class="br-none bb-none">06.</td>
            <td class="bb-none">Student must submit the passport to the representative of Dhaka International
            </td>
        </tr>

        <tr>
            <td class="br-none bb-none"></td>
            <td class="bb-none">University after arrival in Bangladesh. If any student wants to go
                back {{ $foreignStudent->father_nationality ?? 'N/A' }} or He / she
                wants to take his passport, He /She has to
                pay $500.00
            </td>
        </tr>


        <tr>
            <td class="br-none bb-none">07.</td>
            <td class="bb-none">Admission Registration fees: $1000.00</td>
        </tr>

        <tr>
            <td class="br-none bb-none">08.</td>
            <td class="bb-none">Date of Commencement of Class:

                @if($class_str_date_week == 1)
                    {{ $class_str_date_week }} <sup>st</sup>
                @elseif($class_str_date_week == 2)
                    {{ $class_str_date_week }} <sup>nd</sup>
                @elseif($class_str_date_week == 3)
                    {{ $class_str_date_week }} <sup>rd</sup>
                @elseif($class_str_date_week == 4)
                    @if($class_str_date_total_week == $class_str_date_week)
                        last
                    @else
                        <sup>th</sup>
                    @endif
                @elseif($class_str_date_week == 5)
                    @if($class_str_date_total_week == $class_str_date_week)
                        last
                    @else
                        <sup>th</sup>
                    @endif
                @endif

                week of {{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->class_str_date))->format('F') }}
                ,{{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->class_str_date))->format('Y') }}

                (Probably).
            </td>
        </tr>
        <tr>
            <td class="br-none bb-none">09.</td>
            <td class="bb-none">Course Completion
                Date: {{ \Carbon\Carbon::parse(str_replace('/', '-', $batch_details->valid_d_idcard))->format('F Y') }}
                (Probably).
            </td>
        </tr>
        <tr>
            <td class="br-none bb-none">10.</td>
            <td class="bb-none">Confirmation of arrival: Student must inform to the DIU concern office related to
                student
                affairs before 3
                days of arrival in Bangladesh.
            </td>
        </tr>
        <tr>
            <td class="br-none bb-none">11.</td>
            <td class="bb-none">Admission: After arrival in Dhaka admission registration procedure must be completed
                within
                10 days.
            </td>
        </tr>
        <tr>
            <td class="br-none bb-none">12.</td>
            <td class="bb-none">Visa: Foreign Student should apply for visa extension before 2 months of expiring
                date.
            </td>
        </tr>
        <tr>
            <td class="br-none bb-none">13.</td>
            <td class="bb-none"> Hostel: If students stay at the hostel, hostel fee and others charges must pay in time.
            </td>
        </tr>
        <tr>
            <td class="br-none bb-none">14.</td>
            <td class="bb-none">Student must complete his study from this University. Credit transfer is not allowed.
                Transcript will not be
                issued.
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none bt-none">We look forward to welcome you at Dhaka International University.
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none">With best regards,</td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none" style="padding-top: 50px;">Professor Md. Shah Alam Chowdhury</td>
        </tr>

        <tr>
            <td colspan="2" class="bb-none">Additional Registrar</td>
        </tr>

        <tr>
            <td colspan="2" class="bb-none bt-none">Dhaka International University</td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none bt-none">House no-4, Road no-01, Block-F</td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none bt-none">Banani, Dhaka Bangladesh.</td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none bt-none">Cell: +88-01716559369, 01611348346,</td>
        </tr>
        <tr>
            <td colspan="2" class="bb-none bt-none">E-mail: dhakaintluniversity@gmail.com / shahjabeen2010@gmail.com
            </td>
        </tr>
    </table>

</body>
</html>