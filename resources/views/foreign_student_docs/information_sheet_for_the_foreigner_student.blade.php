<p class="reference">{{ $doc->doc_mtg_code?? '' }}</p>
<p class="reference_date">{{ $doc->date ?? '' }}</p>

<h2 class="text-decoration text-center">Dhaka International University</h2>
<h2 class="text-decoration text-center font-bold">Information sheet for the foreigner student</h2>
<p>1. Name of the students: <b>{{ $profile['name'] ?? 'N/A' }}</b></p>
<p>2. Father’s name: <b>{{ $profile['father_name'] ?? 'N/A' }}</b> </p>
<p>3. Mother’s name: <b>{{ $profile['mother_name'] ?? 'N/A' }}</b></p>
<p>4. Permanent address: <b>{{ $profile['permanent_address'] ?? 'N/A' }}</b></p>
<p>5. Present address: <b>{{ $profile['present_address'] ?? 'N/A' }}</b></p>
<p>6. Department: <b>{{ $profile['department_name'] ?? 'N/A' }}</b></p>
<p>7. Batch: <b>{{ $profile['batch_name'] ?? 'N/A' }}</b></p>
<p>8. Roll: <b>{{ $profile['roll']  ?? 'N/A' }}</b></p>
<p>9. Passport no: <b>{{ $profile['passport_no'] ?? 'N/A' }}</b></p>

<p>10. Email Id: <b>{{ $profile['email'] ?? 'N/A' }}</b></p>

<p>11. Facebook Id: </p>

<p>12: Contact no: <b>{{ $profile['https://web.diu.ac/ephoto/11386835716906376661.jpg'] ?? 'N/A' }}</b></p>

<h4 class="text-decoration">Reference in Dhaka</h4>
<p>Name: <b>{{ $profile['reference_name'] ?? 'N/A' }}</b> </p>
<p>Address: <b>{{ $profile['reference_address'] ?? 'N/A' }}</b></p>
<p>Contact no: <b>{{ $profile['reference_contact_no'] ?? 'N/A' }}</b></p>
<p>Facebook: <b>{{ $profile['reference_facebook'] ?? 'N/A' }}</b></p>
<p>Email Id: <b>{{ $profile['reference_email'] ?? 'N/A' }}</b></p>
<p>Relation: <b>{{ $profile['reference_relation'] ?? 'N/A' }}</b></p>
<p class="mt-50">.................................</p>
<p>Signature of student</p>