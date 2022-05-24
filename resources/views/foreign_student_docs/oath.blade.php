{{--@php
    $profile = $pdf_data['profile'];
@endphp--}}

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>


<div style="text-align: center; margin-bottom: 0.2in;">
    <h2>Dhaka International University</h2>
    <h5>House # 04, Road # 01, Block # F, Banani, Dhaka-1213.</h5>
    <h2>Oath</h2>
</div>

<div style="overflow: hidden;">
    <div style="overflow: hidden; float: left; width: 3in;">
        <div style="width: 0.1in; float: left">I</div>
        <div style="float: left;">
            <div style="border-bottom: 1px dotted #000; height: 0.2in;">
                <div style="padding: 0 0.1in;">{{ $profile['name'] }}</div>
            </div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        <div style="width: 1.4in; float: left">bearing Passport no</div>
        <div style="float: left;">
            <div style="border-bottom: 1px dotted #000; height: 0.2in;">
                <div style="padding: 0 0.1in;">{{ $profile['passport_no'] }}</div>
            </div>
        </div>
    </div>
</div>

<div style="overflow: hidden; margin-bottom: 0.2in;">
    <div style="overflow: hidden; float: left; width: 3in;">
        <div style="width: 0.8in; float: left">Citizenship</div>
        <div style="float: left;">
            <div style="border-bottom: 1px dotted #000; height: 0.2in;"></div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.6in;">
        , declaring the following statements:
    </div>
</div>

<ol style="padding: 0 0 0 0.4in; line-height: 0.25in; list-style: number">
    <li>I will maintain the discipline, rules and regulations of Dhaka International University and the country.</li>
    <li>
        <div style="overflow: hidden;">
            <div style="overflow: hidden; float: left; width: 3.5in;">
                <div style="width: 1.7in; float: left">I am getting admitted in</div>
                <div style="float: left;">
                    <div style="border-bottom: 1px dotted #000; height: 0.2in;"></div>
                </div>
            </div>
            <div style="overflow: hidden; float: left; width: 2.7in;">
                <div style="float: left">program/department according to my </div>
            </div>
        </div>
        own will. Nobody has motivated me for getting admission in this program. I will not be allowed to change the batch or the department. If I do so my admission will be canceled and I will take new admission and registration. I am agreed on this point.
    </li>
    <li>I will pay tuition fees as per payment schedule of DIU.</li>
    <li>I will provide all information as per the demand of DIU authority and the law and enforcement organization of Bangladesh.</li>
    <li>I will apply for my visa extension two months before the expiring date.</li>
    <li>I will also provide my house address, mobile number if I change.</li>
    <li>I will show my best behavior with the University teachers, staffs and students as well as with the people of the country. I will maintain the above rules.</li>
    <li>I must complete my study from this University. I will not apply for Credit transfer. I will not apply for Transcript until the course completion. I will --- the above rules.</li>
</ol>

<div style="margin-top: 0.2in;">
    <p>Name : {{ $profile['name'] }}</p>
    <p>Passport : {{ $profile['passport_no'] }}</p>
    <p>Nationality : {{ $profile['nationality'] }}</p>
    <p>Department : {{ $profile['department_name'] }}</p>
    <p>Batch : {{ $profile['batch_name'] }}</p>
    <p>Roll : {{ $profile['roll'] }}</p>
    <p>Semester :  {{ $profile['semester'] }}</p>
    <p>Contact no : {{ $profile['bd_mobile'] }}</p>
</div>
<div style="margin-top: 0.2in;">
    <p>Referred by</p>
    <p>Name -</p>
    <p>Contact -</p>
    <p>Address -</p>
</div>