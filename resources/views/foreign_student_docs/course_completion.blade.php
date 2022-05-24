<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>


<div style="text-align: center; margin-bottom: 0.5in;">
    <h2><u>TO WHOM IT MAY CONCERN</u></h2>
</div>

<p>
    This is to certify that {{ $profile['name'] }}, Passport No- {{ $profile['passport_no'] }}, Nationality- {{ $profile['nationality'] }}, was a student of
    {{ $profile['department_name'] }} program, duration- {{ $profile['program_duration_of_year'] }} years [{{ $profile['total_semester'] }}<sup>th</sup> Semester]
    bearing Roll- {{ $profile['roll'] }}, Registration No. {{ $profile['registration_no'] }}, Batch
    No. {{ $profile['batch_name'] }}<sup>th</sup> under session {{ $profile['session'] ?? 'N/A' }} at Dhaka International University (DIU).
    {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} has completed {{ ($profile['sex'] == 'M') ? 'his' : 'her' }} all prescribed courses.
    Now {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} can leave Bangladesh & we have no obligation. From now on we will not provide
    {{ ($profile['sex'] == 'M') ? 'him' : 'her' }}
    any papers for visa issue as {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is
    no more our valid student.
</p>

<p style="margin-top: 0.1in;">I wish {{ ($profile['sex'] == 'M') ? 'him' : 'her' }} every success in life.</p>


<div style="margin-top: 1in;line-height: 22px;">
    <p>{{ $profile['signature']['name'] }}</p>
    <p>{{ $profile['signature']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>E-mail : {{ $profile['signature']['email'][0] }}</p>
    <p>Or {{ $profile['signature']['email'][1] }}</p>
    <p>Cell: {{ $profile['signature']['cell'] }}</p>
</div>