{{--@php
    $profile = $pdf_data['profile'];
@endphp--}}

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="margin-bottom: 0.1in;">
    <p>Date : {{ date('d/m/Y') }}</p>
    <p>The Honorable Chairman</p>
    <p>Board of Trustees</p>
    <p>Dhaka International University</p>
    <p>Banani, Dhaka-1213</p>
    <p>Subject : Regarding next payment and provisional admission.</p>
</div>

<p>Dear sir,</p>
<p>With due respect, I would like to inform you that I am a foreigner student taking admission now in <span>{{ $profile['subject'] }}</span> Program at your University. I will pay my next payment & taking</p>
<p>provisional admission.</p>

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