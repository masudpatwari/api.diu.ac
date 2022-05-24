<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<p>The Director General</p>
<p>Department of Immigration& Passports</p>
<p>Government of the People’s Republic of Bangladesh</p>
<p>Dhaka</p>
<p>Subject: <span style="text-decoration: underline;">Recommendation for Student Visa Re- verification.</span></p>

<p style="padding: 2px 0">Dear Sir,</p>
<p>This is to certify that {{ $profile['name'] }}, Passport No - {{ $profile['passport_no'] }}, Nationality
    - {{ $profile['nationality'] }}, is a student of {{ $profile['department_name'] }}, Program, duration
    - {{ $profile['program_duration_of_year'] }} years
    [{{ $profile['total_semester'] }}<sup>{{ $sup }}</sup> Semester] bearing Roll No. {{ $profile['roll'] }},
    Registration No.
    {{ $profile['registration_no'] }}, Batch No. {{ $profile['batch_name'] }} under Session {{ $profile['session'] }} at
    Dhaka International University (DIU). Now {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is
    in {{ $profile['running_semester'] }}<sup>{{ $sup }}</sup>
    Semester. </p>

<div style="padding: 2px 0">

    <p>{{ ($profile['sex'] == 'M') ? 'He' : 'She' }} was applying for visa
        extension {{ \Carbon\Carbon::parse(str_replace('/', '-',$profile['created_at'] ))->format('d-m-Y') }}, but SB
        office doesn’t receive {{ ($profile['sex'] == 'M') ? 'his' : 'her' }} application. That
        why {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} did not
        receive any police officer’s phone call. {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} is applying for Re-
        verification.</p>
</div>

<div style="padding: 2px 0">
    <p>
        To the best of my knowledge {{ $profile['name'] }} is not involved or working with any organization or
        company in Bangladesh. {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} is a full time regular student.
    </p>
</div>

<div style="padding:2px 0">
    <p>
        {{ ($profile['sex'] == 'M') ? 'His' : 'Her' }} visa has expired on {{ \Carbon\Carbon::parse(str_replace('/', '-',$profile['visa_date_of_expire'] ))->format('d-m-Y') }}, and it is essential to extend
        {{ ($profile['sex'] == 'M') ? 'his' : 'her' }} visa more than 1 year. We kindly request
        you to take necessary step for renewal and extension of {{ ($profile['sex'] == 'M') ? 'his' : 'her' }} Student Visa.
    </p>

</div>

<div style="padding: 2px 0">
    <p>Hopeful for a positive outcome we do extend our gratitude beforehand.</p>
</div>

<div style=" padding: 2px 0">
    <p>Thanks for your kind co-operation.</p>
</div>

<p>Sincerely yours,</p>


<div style="margin-top: 0.4in;">
    <p>{{ $profile['registrar']['name'] }}</p>
    <p>{{ $profile['registrar']['position'] }}</p>
    <p>{{ $profile['registrar']['uni'] }}</p>
    <p>For further information please contact with the following official:</p>
</div>


<div style="margin-top: 0.4in;">
    <p>{{ $profile['signature']['name'] }}</p>
    <p>{{ $profile['signature']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>E-mail : {{ $profile['signature']['email'][0] }} <span> Or {{ $profile['signature']['email'][1] }}</span></p>
    <p>Cell: {{ $profile['signature']['cell'] }}</p>
</div>
