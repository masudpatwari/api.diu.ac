<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<p>The Director General</p>
<p>Department of Immigration& Passports</p>
<p>Government of the People’s Republic of Bangladesh</p>
<p>Dhaka</p>
<p>Subject: <span style="text-decoration: underline;">Recommendation for issuing an exit Visa.</span></p>

<p style="padding: 5px 0">Dear Sir,</p>
<p>This is to certify that {{ $profile['name'] }}, Passport No - {{ $profile['passport_no'] }}, Nationality
    - {{ $profile['nationality'] }}, was a student of {{ $profile['department_name'] }}, Program, duration
    - {{ $profile['program_duration_of_year'] }} years
    [{{ $profile['total_semester'] }}<sup>{{ $sup }}</sup> Semester] bearing Roll No. {{ $profile['roll'] }},
    Registration No.
    {{ $profile['registration_no'] }}, Batch No. {{ $profile['batch_name'] }} under Session {{ $profile['session'] }} at
    Dhaka International University (DIU). {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} has already
    completed {{ ($profile['sex'] == 'M') ? 'his' : 'her' }} course. </p>

<div style="padding: 5px 0">

    <p>To the best of my knowledge {{ $profile['name'] }} was not involved or working with any organization or company
        in
        Bangladesh. </p>
</div>

<div style="padding: 5px 0">
    <p>{{ ($profile['sex'] == 'M') ? 'His' : 'Her' }} visa expired on

        {{ \Carbon\Carbon::parse(str_replace('/', '-',$profile['visa_date_of_expire'] ))->format('d/m/Y') }}
        .Now {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} wants to go back {{ $profile['nationality'] }}.
        So {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} needs exit visa.
        If {{ ($profile['sex'] == 'M') ? 'he' : 'she' }}
        gets exits visa, we don’t have any objection.</p>
</div>

<div style="padding: 5px 0">
    <p>Hopeful for a positive outcome we do extend our gratitude beforehand.</p>
</div>

<div style=" padding: 5px 0">
    <p>Thanks for your kind co-operation.</p>
</div>

<p>Sincerely yours,</p>


<div style="margin-top: 0.5in;">
    <p>{{ $profile['registrar']['name'] }}</p>
    <p>{{ $profile['registrar']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>For further communication please contact with the following official:</p>
</div>

<div style="margin-top: 0.5in;">
    <p>{{ $profile['signature']['name'] }}</p>
    <p>{{ $profile['signature']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>E-mail : {{ $profile['signature']['email'][0] }} <span> Or {{ $profile['signature']['email'][1] }}</span></p>
    <p>Cell: {{ $profile['signature']['cell'] }}</p>
</div>