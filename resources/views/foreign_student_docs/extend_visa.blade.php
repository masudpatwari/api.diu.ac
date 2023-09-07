{{--@php
    $profile = $pdf_data['profile'];
@endphp--}}

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="margin-bottom: 0.1in;">
    <p>Date : {{ date('d/m/Y') }}</p>
    <p>The Registrar</p>
    <p>Dhaka International University</p>
    <p>Banani, Dhaka-1213</p>
    <p>Subject : Prayer for visa letter/ to extend visa/ Studentship certificate/ Testimonial/ NOC.</p>
</div>

<p>Dear sir,</p>
<p>With due respect, I would like to inform you that I am a foreigner student studying {{ $profile['subject'] }} Program at your University . I need visa letter to extend my visa/need studentship certificate/ to open the bank account/ Testimonial. My visa will expire on {{ $profile['visa_date_of_expire'] }}.</p>
<p> I, therefore, pray and hope that you would be kind enough to issue the above letter for my purpose and oblige there by.</p>

<div style="margin-top: 0.5in;">
    <p>Yours faithfully,</p>
    <p>Name : {{ $profile['name'] }}</p>
    <p>Passport : {{ $profile['passport_no'] }}</p>
    <p>Nationality : {{ $profile['nationality'] }}</p>
    <p>Department : {{ $profile['department_name'] }}</p>
    <p>Batch : {{ $profile['batch_name'] }}</p>
    <p>Roll : {{ $profile['roll'] }}</p>
    <p>Semester :  {{ $profile['running_semester'] }}</p>
    <p>Contact no : {{ $profile['bd_mobile'] }}</p>
    <p>Email ID: {{ $profile['email'] }}</p>
    <p>Address in Bangladesh with house owner contact no: {{ $profile['present_address'] ?? 'N/A' }}</p>
</div>