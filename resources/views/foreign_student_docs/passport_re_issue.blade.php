
<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>



<div style="text-align: center; margin-bottom: 0.5in;">
    <h2><u>TO WHOM IT MAY CONCERN</u></h2>
</div>

<p>This is to certify that {{ $profile['name'] }}, Passport No - {{ $profile['passport_no'] }}, Nationality
    - {{ $profile['nationality'] }}, is a student of {{ $profile['department_name'] }}, Program, duration
    - {{ $profile['program_duration_of_year'] }} years [{{ $profile['total_semester'] }}<sup>{{ $sup }}</sup> Semester]
    bearing Roll No. {{ $profile['roll'] }}, Registration No. {{ $profile['registration_no'] }}, Batch
    No. {{ $profile['batch_name'] }} under Session {{ $profile['session'] }} at Dhaka International University (DIU).
    Now {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is in {{ $profile['running_semester'] }}<sup>{{ $sup }}</sup>
    Semester. {{ ($profile['sex'] == 'M') ? 'His' : 'Her' }} course will be completed
    by {{ \Carbon\Carbon::parse(str_replace('/', '-',$profile['idcard_expire'] ))->format('d F Y') }} (probably). </p>
<p style="margin-top: 0.1in;">To the best of my knowledge {{ $profile['name'] }} is not involved or working with any
    organization or company in Bangladesh. So far as, I know {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is not
    involved in any criminal activity. {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} is a full time regular student.

    {{ ($profile['sex'] == 'M') ? 'His' : 'Her' }} passport was issued on

    @if($profile['date_of_issue'])
        {{ \Carbon\Carbon::parse(str_replace('/', '-',$profile['date_of_issue'] ))->format('d F Y') }}
    @else
        N/A
    @endif
    & expired
    on

    @if($profile['date_of_expire'])
        {{ \Carbon\Carbon::parse(str_replace('/', '-',$profile['date_of_expire'] ))->format('d F Y') }}
    @else
        N/A
    @endif


    .
    If {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} gets new passport we don’t have any objection.
</p>


<p>Present Address: {{ $profile['present_address'] ?? 'N/A' }}</p>

<p style="margin-top: 0.1in;">I wish {{ ($profile['sex'] == 'M') ? 'him' : 'her' }} every success in life.</p>


<div style="margin-top: 0.3in;">
    <p>{{ $profile['registrar']['name'] }}</p>
    <p>{{ $profile['registrar']['position'] }}</p>
    <p>{{ $profile['registrar']['uni'] }}</p>
    <p>For further information please contact with the following official:</p>
</div>


<div style="margin-top: 0.5in;">
    <p>{{ $profile['signature']['name'] }}</p>
    <p>{{ $profile['signature']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>E-mail : {{ $profile['signature']['email'][0] }} <span> Or {{ $profile['signature']['email'][1] }}</span></p>
    <p>Cell: {{ $profile['signature']['cell'] }}</p>

</div>

