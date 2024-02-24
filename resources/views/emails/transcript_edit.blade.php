<!DOCTYPE html>
<html>
<head>
	<title>DIU Transcript Edit Notification</title>
	<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap');
	body{
		font-family: 'Open Sans', sans-serif;
	}
	p{
		margin: 2px;
	}
	</style>
</head>
<body>
	@php

	$label =[
            'name' => 'Name',
            'regcode' => 'Reg. Code',
            'cgpa' => 'CGPA',
            'batch' => 'Batch',
            'roll' => 'Roll',
            'shift' => 'Shift',
            'session' => 'Session',
            'passing_year' => 'Passing Year',
	];
	@endphp
<h4 style="margin: 0">Dear Sir</h4>
<p>This is for your kind information and necessary action that following change has made:</p>

	<ol>
		<li> Reg. Code: {{ $transcript['regcode'] }} {{ array_key_exists("regcode", $transcript_new_array)? ' => ' . $transcript_new_array['regcode']:'' }} </li>

		<li><strong> Change made on: </strong> 
			<ul>
				
				@foreach( $transcript_new_array as $k=>$v )
					@continue( $k =='updated_at' || $k =='updated_by')
					@if( $k =='department')
					<li>Department: {{ $transcript['rel_departments']['name']  }} =>{{ $transcript_new_array[$k]  }}</li>
					@else
					<li> {{ $label[$k] }}: {{ $transcript[$k] }} => {{ $transcript_new_array[$k]  }}</li>
					@endif
				@endforeach
				@if($transcript_file_uploaded)
					<li> File Uploaded</li>
				@endif
			</ul>
		</li>

		<li> Changed by: {{ $employee->name }}  </li>
		<li> Date &amp; Time By: {{ date("d/m/Y", $transcript_new_array['updated_at']) }} @ {{ date("h:i:s A", $transcript_new_array['updated_at']) }}</li>
		<li> IP: {{ $ip }}</li>
	</ol>

<p>Regards</p>
<br>
<p>IT-Team</p>
<p>Dhaka International University</p>
</body>
</html>