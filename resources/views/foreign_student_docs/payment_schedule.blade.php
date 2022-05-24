{{--@php
    $profile = $pdf_data['profile'];
@endphp--}}

<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<table style="margin-bottom: 1.5in;">
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;" colspan="3" align="center">
            <p style="font-size: 16px;"><b>Dhaka International University</b></p>
            <p>Payment schedule for foreigner student</p>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;" colspan="3">
            <p>Name of the students : {{ $profile['name'] }}</p>
            <p>Department: {{ $profile['department_name'] }}</p>
            <p>Batch: {{ $profile['batch_name'] }}</p>
            <p>Roll: {{ $profile['roll'] }}</p>
            <p>Admission date:</p>
            <p>Nationality: {{ $profile['nationality'] }}</p>
            <p>Mobile no: {{ $profile['bd_mobile'] }}</p>
            <p>Passport no: {{ $profile['passport_no'] }}</p>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">Sl no</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Payment description</td>
        <td style="border: 1px solid #000; padding: 0.02in;">Taka</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">1.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Admission fee</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">2.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 1<sup>st</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">3.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 2<sup>nd</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">4.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 3<sup>rd</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">5.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 4<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">6.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 5<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">7.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 6<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">8.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 7<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">9.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 8<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">10.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 9<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">11.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 11<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;">12.</td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;">Before 12<sup>th</sup> semester exam</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
        <td style="border: 1px solid #000; padding: 0.02in; width: 2in;" align="right">Total taka</td>
        <td style="border: 1px solid #000; padding: 0.02in;"></td>
    </tr>
</table>
<p>Seal and signature of admission officer:</p>