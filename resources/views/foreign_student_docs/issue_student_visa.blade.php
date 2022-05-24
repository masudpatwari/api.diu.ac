<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="margin-bottom: 0.1in;">
    <p>The Director General</p>
    <p>Department of Immigration & Passports</p>
    <p>Government of the People's Republic of Bangladesh</p>
    <p>Dhaka</p>
    <p>Subject : Recommendation for issuing a Student Visa.</p>
</div>

<p>Dear Sir,</p>
<p>This is to certify that {{ $profile['name'] }}, Passport No - {{ $profile['passport_no'] }}, Nationality
    - {{ $profile['nationality'] }}, is a student of {{ $profile['department_name'] }}, Program, duration
    - {{ $profile['program_duration_of_year'] }} years [{{ $profile['total_semester'] }}<sup>{{ $sup }}</sup> Semester]
    bearing Roll No. {{ $profile['roll'] }}, Registration No. {{ $profile['registration_no'] }}, Batch
    No. {{ $profile['batch_name'] }} under Session {{ $profile['session'] ?? 'N/A' }} at Dhaka International University (DIU).
    Now {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is in {{ $profile['running_semester'] }}<sup>{{ $sup }}</sup>
    Semester.</p>
<p style="margin-top: 0.1in;">To the best of my knowledge {{ $profile['name'] }} is not involved or working with any
    organization or company in Bangladesh. {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} is a full time regular
    student.</p>
<p style="margin-top: 0.1in;">{{ ($profile['sex'] == 'M') ? 'His' : 'Her' }}
    visa {{ (strtotime(date('Y-m-d')) > strtotime(implode("-", explode("/", $profile['visa_date_of_expire'])))) ? 'has' : 'will be' }}
    expired on

    @if($profile['visa_date_of_expire'])
        {{ \Carbon\Carbon::parse(str_replace('/', '-', $profile['visa_date_of_expire']))->format('d-m-Y') }}
    @else
        N/A
    @endif
    , and it is essential to
    extend {{ ($profile['sex'] == 'M') ? 'his' : 'her' }} visa more than {{ $visa_year ?? 'N/A' }}. We kindly
    request you to take necessary step for renewal and extension of {{ ($profile['sex'] == 'M') ? 'his' : 'her' }}
    Student Visa.</p>
<p style="margin-top: 0.1in;">Hopeful for a positive outcome we do extend our gratitude beforehand.</p>
<p style="margin-top: 0.1in;">Thanks for your kind co-operation.</p>
<p style="margin-top: 0.1in;">Sincerely yours,</p>

<div style="margin-top: 0.3in;">
    <p>{{ $profile['registrar']['name'] }}</p>
    <p>{{ $profile['registrar']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>For further communication please contact with the following official:</p>
</div>

<div style="margin-top: 0.3in;">
    <p>{{ $profile['signature']['name'] }}</p>
    <p>{{ $profile['signature']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>E-mail : {{ $profile['signature']['email'][0] }}</p>
    <p>Or {{ $profile['signature']['email'][1] }}</p>
    <p>Cell: {{ $profile['signature']['cell'] }}</p>
</div>