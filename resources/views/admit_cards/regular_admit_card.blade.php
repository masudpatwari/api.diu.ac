<div style="overflow: hidden; margin-bottom: 0.05in;">
	<div style="border: 1px solid #000; width: 1.5in; height: 1.5in; text-align: center; float: left;">
		@php
            $url = '';
            try{
                $img = file_get_contents("ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $id . ".JPG");
                $url = "ftp://" . env("ERP_FTP_USERNAME") . ":" . env("ERP_FTP_USERPASSWORD") . "@" . env("ERP_FTP_HOST") ."/STD" . $id . ".JPG";

                if( strlen($img) == 2739 || strlen($img) == 0 ){
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
        @if(empty($url))
        <p style="margin-top: 0.5in">Passport size photo</p>
        @else
        <img src="{{ 'data:image/jpg;base64,'. base64_encode($img) }}" alt="Passport size photo">
        @endif
	</div>
	<div style="text-align: center; width: 5.7in; float: left;">
		<div style="text-align: center; width: 5in; float: left;">
			<div style="width: 4.5in">
				<h3 style="font-size: 20px;">Dhaka International University</h3>
				<p>Administrative Building, House No. 04, Road No. 01, Block - F, Banani, Dhaka - 1213</p>
			</div>
	        <div style="width: 2.50in; float: left; text-align: right;">
	        	<img src="{{ storage_path('assets/diu_logo.png') }}" alt="" style="width: 80px;">
	        </div>
	        <div style="width: 1.05in; float: right; text-align: left; margin-top: 20px;">
	        	<h3 style="font-size: 11px; margin-bottom: 4px">SL. {{ $admit_sl_no }}</h3>
	        </div>
		</div>
		<div style="text-align: center; width: 100%; float: left;">
			<div style="text-align: center; width: 3.97in; float: left;">
				<img src="{{ storage_path('assets/admit_card.png') }}" alt="" style="width: 160px; margin: 5px 0;">
			</div>
	        <div style="width: 1.60in; float: right; text-align: left; padding: 8px 5px; border: 1px solid #000">
		        <div style="overflow: hidden; margin-bottom: 8px;">
		            <div style="width: 0.65in; float: left;">Class Roll No</div>
		            <div style="width: 0.95in; float: left; border-bottom: 1px dotted #000;">{!! $roll ?? '&nbsp;' !!}</div>
		        </div>
		        <div style="overflow: hidden; margin-bottom: 8px;">
		            <div style="width: 0.50in; float: left;">Batch No</div>
		            <div style="width: 1.10in; float: left; border-bottom: 1px dotted #000;">{!! $batch ?? '&nbsp;' !!}</div>
		        </div>
		        <div style="overflow: hidden; margin-bottom: 8px;">
		            <div style="width: 0.45in; float: left;">Regn No</div>
		            <div style="width: 1.15in; float: left; border-bottom: 1px dotted #000;">{!! $reg_code ?? '&nbsp;' !!}</div>
		        </div>
		        <div style="overflow: hidden; margin-bottom: 0;">
		            <div style="width: 0.40in; float: left;">Session</div>
		            <div style="width: 1.20in; float: left; border-bottom: 1px dotted #000;">{!! $session ?? '&nbsp;' !!}</div>
		        </div>
	        </div>
		</div>
	</div>
</div>
<div style="overflow: hidden; margin-bottom: 0.1in; font-size: 11px;">
    <div style="width: 0.75in; float: left;"><strong>Department</strong></div>
    <div style="width: 2.2in; float: left; border-bottom: 1px dotted #000;">{!! $department ?? '&nbsp;' !!}</div>
    <div style="width: 0.85in; float: left;"><strong>Hons/Masters</strong></div>
    <div style="width: 1in; float: left; border-bottom: 1px dotted #000; padding-left: 4px">{!! $semester ??  '&nbsp;' !!}</div>
    <div style="width: 1.8in; float: left; text-transform: capitalize;"><strong>Semester Final Examinations - </strong></div>
    <div style="width: 0.55in; float: left; border-bottom: 1px dotted #000;">{{ date('Y') }}</div>
</div>

<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">
    	<p>Full Name of the Examinee</p>
    	<p>(According to S.S.C Certificate)</p>
    </div>
    <div style="width: 0.5in; float: left;">Bengali</div>
    <div style="width: 4.64in; float: left; border-bottom: 1px dotted #000;">&nbsp;</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">&nbsp;</div>
    <div style="width: 0.5in; float: left;">English</div>
    <div style="width: 4.64in; float: left; border-bottom: 1px dotted #000;">{!! strtoupper($name) ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">Father's Name</div>
    <div style="width: 5.14in; float: left; border-bottom: 1px dotted #000;">{!! $father_name ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 2.1in; float: left;">Mother's Name</div>
    <div style="width: 5.14in; float: left; border-bottom: 1px dotted #000;">{!! $mother_name ?? '&nbsp;' !!}</div>
</div>
<div style="overflow: hidden; margin: 5px 0;">
	<p>Course No and Title of the Courses appearing at the Semester Final Examinations</p>
</div>
<div style="overflow: hidden; margin: 5px 0 10px;">
@if(!empty($allocated_course))
@php
$i = 1;
@endphp
@foreach($allocated_course as $key => $course)
<div style="float: left; width: 3.6in; margin: 5px 0;">
    <div style="width: 0.26in; float: left;">({{ integerToRoman($i++) }})</div>
    <div style="width: 3.19in; float: left; border-bottom: 1px dotted #000;">&nbsp;{{ $course['code'].' - '.$course['name'] }}</div>
</div>
@endforeach
@endif
</div>
<!-- 
@for($i=1; $i<=12;$i=$i+2)
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 0.26in; float: left;">({{ integerToRoman($i) }})</div>
    <div style="width: 3.19in; float: left; border-bottom: 1px dotted #000;">&nbsp;{{ isset($allocated_course[ $i-1 ]) ? $allocated_course[ $i-1 ]['code'].' - '.$allocated_course[ $i-1 ]['name'] : '' }}</div>
    <div style="width: 0.26in; float: left; margin-left: 0.17in;">({{ integerToRoman($i+1) }})</div>
    <div style="width: 3.36in; float: left; border-bottom: 1px dotted #000;">&nbsp;{{ isset($allocated_course[$i]) ? $allocated_course[$i]['code'].' - '.$allocated_course[$i]['name'] : '' }}</div>
</div>
@endfor
 -->
<div style="overflow: hidden; margin: 5px 0;">
    <div style="width: 3.19in; float: left;"><strong>Starting Date of the Examinations : {!! $exam_start_date ?? '&nbsp;' !!}</strong></div>
    <div style="width: 3.36in; float: left;">(Please check the final schedule at www.students.diu.ac )</div>
</div>

<div style="overflow: hidden; margin: 40px 0 5px;">
    <div style="width: 2in; float: left; border-top: 1px solid #000; padding-top: 5px;">
        <p><strong>Audit Officer</strong></p>
    </div>
    <div style="width: 2in; text-align: center; float: left; border-top: 1px solid #000; padding-top: 5px; margin-left: 60px;">
        <p><strong>Controller of Examinations</strong></p>
    </div>
    <div style="width: 2in; text-align: center; float: right; border-top: 1px solid #000; padding-top: 5px;">
        <p><strong>Signature of the Examinee</strong></p>
    </div>
</div>