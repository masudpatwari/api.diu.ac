@php
    
    function convertSemester ( $number ){
	    $replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
	    $search_array= array("১ম", "২য়", "৩য়", "৪র্থ", "৫ম", "৬ষ্ঠ", "৭ম", "৮ম", "৯ম", "০");
	    $bn_number = str_replace($replace_array, $search_array, $number);
	    return $bn_number;
	}

	function en2bnDate ($date){
	    $date = date('d F Y', strtotime($date));
		$search_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বার", "ডিসেম্বার", ":", ",");
		$replace_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", ":", ",");
		$bn_date = str_replace($replace_array, $search_array, $date);
		return $bn_date;
	}

@endphp

<div style="text-align: center; margin-bottom: 0.5in;">
    <h2><b>নোট নং </b></h2>
</div>





<p><span><b>{{ $profile['name'] }},</b> Passport No. <b>{{ $profile['passport_no'] }},</b> Nationality - <b>{{ $profile['nationality'] }}, {{ $profile['department_name'] }} Program</b></span> এর {{ convertSemester($profile['running_semester']) }} সেমিস্টারের ছাত্র। তার ভিসার মেয়াদ {{ en2bnDate($profile['visa_date_of_expire']) }} ইং শেষ {{ (strtotime(date('Y-m-d')) > strtotime(implode("-", explode("/", $profile['visa_date_of_expire'])))) ? 'হয়েছে' : 'হবে' }}। এমতাবস্থায় তার ভিসার মেয়াদ বাড়ানোর লক্ষে নিম্মোক্ত পত্রাদি সরবরাহের নিমিত্তে অনুমতি চেয়ে নথি উপস্থাপন করা হলো।</p>
<ol style="margin-top: 0.5in; padding-left: 1in">
	<li><span>Studentship Certificate</span></li>
	<li><span>To Whom It May Concern</span></li>
	<li><span>Recommendation Letter</span></li>
	<li><span>Recommendation for issuing a Student Visa</span></li>
	<li><span>Bonafide Letter</span></li>
	<li><span>Sponsorship Certificate</span></li>
</ol>
<div style="margin-top: 1.5in;">
{{--    <p align="right" style="margin: 0; line-height: 16px">সহযোগী অধ্যাপক শাহ্ আলম চৌধুরী</p>--}}
    <p align="right" style="margin: 0; line-height: 16px">অধ্যাপক শাহ্ আলম চৌধুরী</p>
    <p align="right" style="margin: 0; line-height: 16px">এডিশনাল রেজিষ্ট্রার ( ছাত্র কল্যাণ )</p>
    <p align="right" style="margin: 0; line-height: 16px">ঢাকা ইন্টারন্যাশনাল ইউনিভার্সিটি</p> 
</div>
<div style="margin-top: 1in;">
	<div style="float: left; width: 1.77in; text-align: left;">রেজিস্ট্রারঃ</div>
	<div style="float: left; width: 1.77in; text-align: left;">উপাচার্যঃ </div>
	<div style="float: left; width: 2.2in; text-align: left;">চেয়ারম্যান/ভাইস-চেয়ারম্যান, বিওটিঃ </div>
</div>