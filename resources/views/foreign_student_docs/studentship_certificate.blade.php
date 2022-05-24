
<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<div style="text-align: center; margin-bottom: 0.5in;">
    <h2><u>Studentship Certificate</u></h2>
</div>

<p>This is to certify that {{ $profile['name'] }}, Passport No - {{ $profile['passport_no'] }}, Nationality - {{ $profile['nationality'] }}, is a student of {{ $profile['department_name'] }}, Program, duration - {{ $profile['program_duration_of_year'] }} years [{{ $profile['total_semester'] }}<sup>{{ $sup }}</sup> Semester] bearing Roll No. {{ $profile['roll'] }}, Registration No. {{ $profile['registration_no'] }}, Batch No. {{ $profile['batch_name'] }} under Session {{ $profile['session'] }} at Dhaka International University (DIU). Now {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is in {{ $profile['running_semester'] }}<sup>{{ $sup }}</sup> Semester.</p>
<p style="margin-top: 0.1in;">To the best of my knowledge {{ $profile['name'] }} is not involved or working with any organization or company in Bangladesh. So far as I khow {{ ($profile['sex'] == 'M') ? 'he' : 'she' }} is not involved in any criminal activity. {{ ($profile['sex'] == 'M') ? 'He' : 'She' }} is a full time regular student.</p>
<p style="margin-top: 0.1in;">I wish {{ ($profile['sex'] == 'M') ? 'him' : 'her' }} every success in life.</p>

<div style="margin-top: 0.3in;">
    <p>{{ $profile['registrar']['name'] }}</p>
    <p>{{ $profile['registrar']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>&nbsp;</p>
    <p>For further communication please contact with the following official:</p>
</div>

<div style="margin-top: 0.5in;">
    <p>{{ $profile['signature']['name'] }}</p>
    <p>{{ $profile['signature']['position'] }}</p>
    <p>{{ $profile['signature']['uni'] }}</p>
    <p>E-mail : {{ $profile['signature']['email'][0] }}</p>
    <p>Or {{ $profile['signature']['email'][1] }}</p>
    <p>Cell: {{ $profile['signature']['cell'] }}</p>
</div>