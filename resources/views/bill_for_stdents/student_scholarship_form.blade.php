@php
	function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}
@endphp
<table>
		{{-- @dd($admittedStudent, $admittedByStudent)	 --}}
	<tbody>
		<tr>
			<td width="50%">
				
				<table class="table table-bordered table-sm mb-0" id="liasionOfficersTable">
				<tr>
					<td colspan="4">
						<table>
							<tbody>
								<tr>
									<td colspan="3"><img src="https://help.diu.ac/wp-content/uploads/2019/09/logo_color-1.png" alt=""> </td>
									<td colspan="7">
										<h3>Dhaka International University</h3>
										House#04,  Road#01, Block-F. Banani, Dhaka-1213
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr> <td colspan="4" style="font-size: 20px; text-decoration: underline; text-align: center; margin-bottom: 40px; height: 49px; font-weight: 600;">Scholarship Form</td> </tr>
				<tr>
						<td colspan="4"> 
							<div style=" font-weight: 600;text-decoration: underline; ">
								Information of Admitted Student: 
							</div>
							
							Name of the program: {{ $admittedStudent['department']['name'] }}<br> 
							Applicants Name: {{ $admittedStudent['name'] }}<br> 
							Father’s Name: {{ $admittedStudent['f_name'] }}<br>
							Batch: {{ $admittedStudent['batch']['batch_name'] }} Roll: {{ $admittedStudent['roll_no'] }} , Registration Code:{{ $admittedStudent['reg_code'] }}  <br>
							Admission Form Number: {{ $admittedStudent['adm_frm_sl'] }} Admission Date: {{ str_replace("00:00:00", '', $admittedStudent['adm_date']) }}<br>
							Admission Fee Paid: {{ $admittedStudent['adm_fee'] }}
							
							<br>
							<br>

							<div style=" font-weight: 600; text-decoration: underline;">
								Information of Existing Student:
							</div>
							
							Name: {{ $admittedByStudent['name'] }}<br> 
							Department: {{ $admittedByStudent['department']['name'] }}<br> 
							Batch: {{ $admittedByStudent['batch']['batch_name'] }} Roll# {{ $admittedByStudent['roll_no'] }} 
							Shift: 
								@if($admittedByStudent['shift_id']==1)
								Day
								@elseif($admittedByStudent['shift_id']==2)
								Evening
								@else
								Friday-Saturday
								@endif

							  <br>Registration Code:{{ $admittedByStudent['reg_code'] }} , Mobile Number:{{ $admittedByStudent['phone_no'] }}   <br>
							Scholarship Amount: {{ $admittedStudent['amount'] }} <br>
							In Word: <span style="text-transform: capitalize;">{{ convertNumberToWord($admittedStudent['amount'])}}</span> taka only
						 	<br><br>
						 	<br><br>
						</td>
				</tr>
				<tr> 
					<td colspan="2">
						{{ $admittedByStudent['name'] }} <br> 
						{{ $admittedByStudent['phone_no'] }} <br> 
						{{ date('d/m/Y') }}
					</td> 
					<td colspan="2"> 
						{{ $admittedStudent['admissionOfficer']['emp_name']}} <br>
						{{ $admittedStudent['admissionOfficerPosition']['name']}}<br>
						{{ $admittedStudent['admissionOfficerDept']['name']}}
					</td> 
				</tr>
				<tr> 
					<td colspan="4"><br><br><br><br></td> 
				</tr>
				<tr> 
					<td colspan="2">Head of Information & Admission </td> 
					<td colspan="2">Chairman/Vice-Chairman, BOT <br><br><br><br></td> 
				</tr>
				<tr> 
					<td colspan="4"> Posted on:  “{{ $admittedStudent['reg_code'] }}” / “{{ $admittedByStudent['reg_code'] }}” <br>
						Recite Number {{ $admittedByStudent['id'] }}-{{ $admittedStudent['id'] }}  Date: {{ date("dd/mm/Y") }} Cash ID: ……………..
						<br><br><br><br>
					</td>
				</tr>

				<tr> 
					<td colspan="2"> Seal, Signature and Date of Accounts officer</td> 
					<td></td> 
				</tr>
			</table>

			</td>
			<td>
			<table class="table table-bordered table-sm mb-0" id="liasionOfficersTable">
				<tr>
					<td colspan="4">
						<table>
							<tbody>
								<tr>
									<td colspan="3"><img src="https://help.diu.ac/wp-content/uploads/2019/09/logo_color-1.png" alt=""> </td>
									<td colspan="7">
										<h3>Dhaka International University</h3>
										House#04,  Road#01, Block-F. Banani, Dhaka-1213
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
						<td colspan="4"> 
							To <br>
							{{ $admittedByStudent['name'] }}<br>
							{{ $admittedByStudent['department']['name'] }}<br>
							Batch: {{ $admittedByStudent['batch']['batch_name'] }}. Roll # {{ $admittedByStudent['roll_no'] }} 

							Shift: 
								@if($admittedByStudent['shift_id']==1)
								Day
								@elseif($admittedByStudent['shift_id']==2)
								Evening
								@else
								Friday-Saturday
								@endif
							 
							Regcode: {{ $admittedByStudent['reg_code'] }} <br>	


							 <br>
							Dear Students<br>  
							On behalf of Dhaka International University I would like to say thank you for being a loyal Family Member. It has been a pleasure serving your students and admitted with us: <br><br>

							
							<div style=" font-weight: 600;text-decoration: underline; ">
								Information of Admitted Student: 
							</div>
							
							Name of the program: {{ $admittedStudent['department']['name'] }}<br> 
							Applicants Name: {{ $admittedStudent['name'] }}<br> 
							Father’s Name: {{ $admittedStudent['f_name'] }}<br>
							Batch: {{ $admittedStudent['batch']['batch_name'] }} Roll: {{ $admittedStudent['roll_no'] }} , Registration Code:{{ $admittedStudent['reg_code'] }}  <br>
							Admission Form Number: {{ $admittedStudent['adm_frm_sl'] }} Admission Date: {{ str_replace("00:00:00", '', $admittedStudent['adm_date']) }}<br>
							
							<br>
							<br>
							 We hope that we can have the pleasure of providing for you and your student for many more years to come. <br><br>

							Dhaka International University is committed to providing our Students with only the highest quality of Education delivered through impeccable Education System.<br><br>

							As proof of our appreciation for your loyalty and ongoing support, we would like to give you a small Scholarship. Once again, thank you for your ongoing co-operation and we look forward to serving you in forthcoming months.

							<br> <br>

							Best regards,
							<br><br>
							<br><br>
							{{-- @dd($student) --}}
							{{-- Name of the admission officer  --}}
							{{ $admittedStudent['admissionOfficer']['emp_name']}} <br>
							{{-- Designation --}}  
							{{ $admittedStudent['admissionOfficerDept']['name']}} <br>
							Date: {{ date('d/m/Y')}} <br>
							Mobile: {{ $admittedStudent['admissionOfficer']['mobile_no_1']}}
						</td>
				</tr>
				
			</table>
			</td>
		</tr>
	</tbody>
</table>

			
			
