
<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="text-align: center; margin-bottom: 0.2in;">
    <h3>Dhaka International University</h3>
    <h4>Admission Letter</h4>
</div>

<div style="margin-bottom: 0.2in;">
    <p>Date :{{ date('d/m/Y') }}</p>
    <p>The Register</p>
    <p>Dhaka International University</p>
    <p>Banani, Dhaka-1213</p>
    <p>Subject : For admission letter.</p>
    <p>Dear sir,</p>
</div>
<div style="overflow: hidden;">
    <div style="width: 0.3in; float: left">I am</div>
    <div style="float: left;">
        <div style="border-bottom: 1px dotted #000; height: 0.2in;">
            <div style="padding: 0 0.1in;">{{ $profile['name'] }}</div>
        </div>
    </div>
</div>
<div style="overflow: hidden;">
    <div style="overflow: hidden; float: left; width: 3.3in;">
        <div style="width: 0.8in; float: left">Nationality</div>
        <div style="float: left;">
            <div style="border-bottom: 1px dotted #000; height: 0.2in;">
                <div style="padding: 0 0.1in;">{{ $profile['nationality'] }}</div>
            </div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 3.3in;">
        <div style="width: 0.8in; float: left">Passport no</div>
        <div style="float: left;">
            <div style="border-bottom: 1px dotted #000; height: 0.2in;">
                <div style="padding: 0 0.1in;">{{ $profile['passport_no'] }}</div>
            </div>
        </div>
    </div>
</div>
<div style="overflow: hidden;">
    <div style="width: 1.1in; float: left">Present address</div>
    <div style="float: left;">
        <div style="border-bottom: 1px dotted #000; height: 0.2in;">
            <div style="padding: 0 0.1in;">{{ $profile['present_address'] }}</div>
        </div>
    </div>
</div>
<div style="overflow: hidden; margin-bottom: 0.2in">
    <div style="overflow: hidden; float: left; width: 2.6in;">
        <div style="width: 0.5in; float: left">Cell no</div>
        <div style="float: left;">
            <div style="border-bottom: 1px dotted #000; height: 0.2in;">
                <div style="padding: 0 0.1in;">{{ $profile['bd_mobile'] }}</div>
            </div>
        </div>
    </div>
    <div style="overflow: hidden; float: left; width: 4in;">
        <div style="float: left">&nbsp;, demanding an admission letter for the following person :</div>
    </div>
</div>
<div style="margin-bottom: 0.1in;">
    <p>Name : {{ $profile['name'] }}</p>
    <p>Passport no : {{ $profile['passport_no'] }}</p>
    <p>Date of Birth : {{ $profile['dob'] }}</p>
    <p>Nationality : {{ $profile['nationality'] }}</p>
    <p>Area of interest / Name of department: {{ $profile['subject'] }}</p>
    <p>Submitted documents : </p>
</div>
<div style="margin-bottom: 0.1in;">
    <p>1.Photocopy of all academic transcript.</p>
    <p>2.Photocopy of passport.</p>
</div>
<div style="margin-bottom: 0.2in;">
    <p>After arrival in Bangladesh student must hand over his/her passport to the representative of DIU authority and student must complete registration process wihtin five days.</p>
</div>
<div style="margin-bottom: 0;">
    <p>Yours faithfully,</p>
    <p>Name : {{ $profile['name'] }}</p>
    <p>Mobile no : {{ $profile['bd_mobile'] }}</p>
    <p>Email : {{ $profile['email'] }}</p>
</div>