{{--@php
    $profile = $pdf_data['profile'];
@endphp--}}

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="text-align: center; margin-bottom: 0.4in;">
    <h4>For another University's student's admission</h4>
</div>

<div style="margin-bottom: 0.1in;">
    <p>Date : {{ date('d/m/Y') }}</p>
    <p>The Registrar</p>
    <p>Board of Trustees</p>
    <p>Dhaka International University</p>
    <p>Banani, Dhaka-1213</p>
    <p>Subject : Regarding admission.</p>
</div>

<p>Dear sir,</p>
<p>We due respect, I would like to inform you that I am a foreigner student taking admission now in <span>{{ $profile['subject'] }}</span> program at your University. But I have taken admission letter <span> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> From <span>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Program. I will not study there.</p>
<p>I,therefore,pray and hope that you would be kind enough to allow me for my provisional admission.</p>

<div style="margin-top: 0.5in;">
    <p>Yours faithfully,</p>
    <p>Name : {{ $profile['name'] }}</p>
    <p>Passport : {{ $profile['passport_no'] }}</p>
    <p>Nationality : {{ $profile['nationality'] }}</p>
    <p>Department : {{ $profile['department_name'] }}</p>
    <p>Batch : {{ $profile['batch_name'] }}</p>
    <p>Roll : {{ $profile['roll'] }}</p>
    <p>Semester :  {{ $profile['semester'] }}</p>
    <p>Contact no : {{ $profile['bd_mobile'] }}</p>
</div>