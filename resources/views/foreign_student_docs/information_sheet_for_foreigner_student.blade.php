@php
    $profile = $pdf_data['profile'];
@endphp
<div style="text-align: center; margin-bottom: 0.5in;">
    <h3 style="margin: 0.05in 0;">Dhaka International University</h3>
    <h2>Information Sheet for foreigner student</h2>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>1.Name of the student:</strong> {{ $profile['name'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>2.Father's name:</strong> {{ $profile['father_name'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>3.Mother's name:</strong> {{ $profile['mother_name'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>4.Permanent address:</strong> {{ $profile['permanent_address'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>5.Present address:</strong> {{ $profile['present_address'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 3.3in;">
        <strong>6.Department:</strong> {{ $profile['department_name'] }}
    </div>
    <div style="float: right; width: 3.3in;">
        <strong>7.Batch:</strong> {{ $profile['batch_name'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>8.Roll:</strong> {{ $profile['roll'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>9.Passport no:</strong> {{ $profile['passport_no'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>10.Email Id:</strong> {{ $profile['email'] }}
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>11.Facebook Id:</strong>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>12.Contact no:</strong> {{ $profile['bd_mobile'] }}
    </div>
</div>

<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong><u>Reference in Dhaka</u></strong>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>Name:</strong> 
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 7.2in;">
        <strong>Address:</strong>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 3.3in;">
        <strong>Contact no:</strong>
    </div>
    <div style="float: right; width: 3.3in;">
        <strong>Facebook</strong>
    </div>
</div>
<div style="overflow: hidden; margin-bottom:0.05in;">
    <div style="float: left; width: 3.3in;">
        <strong>Email Id:</strong>
    </div>
    <div style="float: right; width: 3.3in;">
        <strong>Relation</strong>
    </div>
</div>

<div style="overflow: hidden; margin-top: 0.8in;">
    <div style="width: 2in; float: left;">
        <div style="border-bottom: 1px solid #000;"></div>
        <div style="text-align: center;"><strong>Signature of student</strong></div>
    </div>
</div>