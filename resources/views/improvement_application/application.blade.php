<div style="overflow: hidden; margin-bottom: 0.2in;">
    <div style="border: 1px solid #000; width: 1.5in; height: 1.5in; text-align: center; float: left;">
        @php
            $url = '';
            try{
                $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $id . ".JPG");
                $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $id . ".JPG";
                // dd(strlen($img), $img );
                if( strlen($img) == 2739 || strlen($img) == 32634 || strlen($img) == 0 ){
                    $img = file_get_contents( env("APP_URL") . "images/student_profile_photo_" . $id . ".jpg",false, stream_context_create(
                        [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            ],
                        ]));

                    $url = env("APP_URL") . "images/student_profile_photo_" . $id . ".jpg";
                }
            }
            catch (\Exception $exception){
                try{
                    $img = file_get_contents( env("APP_URL") . "images/student_profile_photo_" . $id . ".jpg",false, stream_context_create(
                        [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            ],
                        ]));

                    $url = env("APP_URL") . "images/student_profile_photo_" . $id . ".jpg";
                }
                catch (\Exception $exception){
                    $url = "";
                }
            }
        @endphp
        @if(empty($url) || $payment_status != 'PAID')
        <p style="margin-top: 0.5in">Passport size photo</p>
        @else
        <img src="{{ $url }}" alt="Passport size photo">
        @endif
    </div>

    <div style="text-align: center; width: 4in; float: left;">
        <div style="padding-left: 10px;">
            <div style="width: 80px; float: left;">
                <img src="{{ storage_path('assets/diu_logo.png') }}" alt="">
            </div>
            <div style="width: 3in; float: right;">
                <h3 style="font-size: 16px;">Dhaka International University</h3>
                <p>Administrative Building</p>
            </div>
            <div>
                <p>House No. 04, Road No. 01, Block - F, Banani, Dhaka - 1213</p>
                <p>Phone : 55040891-7</p>
                <h2 style="font-size: 16px; text-transform: uppercase; margin-bottom: 2px;">Application Form</h2>
                <p style="width: 3in; margin: 0 auto; padding: 2px; background-color: #000; font-size: 15px; color: #fff">For {{ $type=='incourse'? 'In-Course': title_case($type) }} Improvement Examination</p>
            </div>
        </div>
    </div>
    <div style="width: 1.65in; float: right; text-align: right;">
        <div style="overflow: hidden; margin-bottom: 10px;">
            <div style="width: 0.60in; float: left;">Receipt No</div>
            <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">{!! ($payment_status == 'PAID') ? $receipt_no : '&nbsp;' !!}</div>
        </div>
        <div style="overflow: hidden; margin-bottom: 10px;">
            <div style="width: 0.60in; float: left;">Date</div>
            <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">{!! ($payment_status == 'PAID') ? $pay_date : '&nbsp;' !!}</div>
        </div>
        <div style="overflow: hidden; margin-bottom: 10px;">
            <div style="width: 0.60in; float: left;">Received Tk</div>
            <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">{!! ($payment_status == 'PAID') ? $paid_amount.' Tk' : '&nbsp;' !!}</div>
        </div>
        <div style="overflow: hidden; margin: 0;">
            <div style="width: 0.60in; float: left;">Invoice No</div>
            <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">{!! ($payment_status == 'PAID') ? $invoice_number : '&nbsp;' !!}</div>
        </div>
    </div>
</div>
{{--
'id' => $studentObj->id,
'name' => $studentObj->name,
'roll' => $studentObj->roll_no,
'reg_coe' => $studentObj->reg_code,
'father_name' => $studentObj->f_name ?? '',
'mother_name' => $studentObj->m_name ?? '',
'department' => $studentObj->department->name,
'batch' => $studentObj->batch->batch_name,
'applied_courses'=> $appliedCourses,
'total_cost' => $totalCost,
'improvement_exam_info'=> [
"id" => 4
"name" => "2019 Exam"
"exam_start_date" => "2019-10-30"
"form_fillup_last_date" => "2019-10-25"
"h_inon_fee" => "100"
"h_fion_fee" => "100"
"h_intw_fee" => "200"
"h_fitw_fee" => "200"
"h_inth_fee" => "300"
"h_fith_fee" => "300"
"m_inon_fee" => "100"
"m_fion_fee" => "100"
"m_intw_fee" => "200"
"m_fitw_fee" => "200"
"m_inth_fee" => "300"
"m_fith_fee" => "300"
"approve_status" => "0"
"approve_by" => null
]
--}}
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">1. Name of the Student</div>
    <div style="width: 5.14in; float: left; border-bottom: 1px dotted #000;">{!! $name ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">2. Father's Name</div>
    <div style="width: 5.14in; float: left; border-bottom: 1px dotted #000;">{!! $father_name ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">3. Mother's Name</div>
    <div style="width: 5.14in; float: left; border-bottom: 1px dotted #000;">{!! $mother_name ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">4. Name of Department/Program</div>
    <div style="width: 5.14in; float: left; border-bottom: 1px dotted #000;"> {!! $department ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 0.75in; float: left;">5. Batch No</div>
    <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">{!! $batch ?? '&nbsp;' !!}</div>
    <div style="width: 0.45in; float: left;">Roll No</div>
    <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">&nbsp;{!! $roll ?? '&nbsp;' !!}</div>
    <div style="width: 0.94in; float: left;">Registration No</div>
    <div style="width: 1.6in; float: left; border-bottom: 1px dotted #000;">{!! $reg_code ?? '&nbsp;' !!}</div>
    <div style="width: 0.50in; float: left;">Session</div>
    <div style="width: 1in; float: left; border-bottom: 1px dotted #000;">{!! $session ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">6. Course No. & Title :</div>
</div>
@for($i=1; $i<=14;$i=$i+2)
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 0.26in; float: left;">({{ integerToRoman($i) }})</div>
    <div style="width: 3.19in; float: left; border-bottom: 1px dotted #000;">&nbsp;{{ isset($applied_courses[ $i-1 ]) ? $applied_courses[ $i-1 ]['code'].' - '.$applied_courses[ $i-1 ]['name'] : '' }}</div>
    <div style="width: 0.26in; float: left; margin-left: 0.17in;">({{ integerToRoman($i+1) }})</div>
    <div style="width: 3.36in; float: left; border-bottom: 1px dotted #000;">&nbsp;{{ isset($applied_courses[$i]) ? $applied_courses[$i]['code'].' - '.$applied_courses[$i]['name'] : '' }}</div>
</div>
@endfor
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">7. Total Amounts : {{ $total_cost ?? 0 }}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">8. Dealing Officer : </div>
</div>
<div style="overflow: hidden; margin: 30px 0 5px;">
    <div style="width: 2in; float: left; border-top: 1px dotted #000; padding-top: 5px;">
        <p><strong>Controller of Examinations</strong></p>
    </div>
    <div style="width: 2in; float: right; border-top: 1px dotted #000; padding-top: 5px;">
        <p><strong>Signature of the Student</strong></p>
    </div>
</div>
<div style="overflow: hidden; margin: 10px 0 0;">
    <div style="width: 2in; float: right; border-bottom: 1px dotted #000; padding-top: 5px;">
        <p><strong>Date</strong></p>
    </div>
</div>