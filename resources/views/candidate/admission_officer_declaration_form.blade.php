<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
     
    </style>
</head>

<body>
	

    <table width="100%" style="line-height:28px">		
        <tr>
            <td style="text-align:left;font-size:18px">
                <p style="font-size:40px;font-weight:bold;">{{ $data->name }}</p>
                <p>{{ $data->email }}</p>
                <p>{{ $data->phone }}</p>
                <p style="text-transform: capitalize;">{{ $data->age }} Years Old {{ $data->status }} {{ $data->gender }}</p>
            </td>
            <td style="text-align: right"><img src="https://api.diu.ac/{{ $data->image }}" alt="imge"
                    height="150px" width="150px"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <h1 ><b><u>Self Declaration</u> </b></h1> <br><br>
            </td>
        </tr>
		<tr >
			<td colspan="2">
				<p>I am declaring that my Height is ….. fits ….. inches & have adequate computer operating knowledge for doing my daily official work digitally. I applied for the position of Junior Officer (Admission & Information) at Dhaka International University (DIU) & I know the following terms and condition of the Job & agreed there by: </p>		
				<ol style="margin-left: 500px !importent;" >
					<li>&nbsp;&nbsp; Admission & Information office is active 24 hours in a day and 7 days in a week. Usually Physical Office open from 07:00 AM to 09:00 PM and Home office from 09:00 PM to 07:00 AM. There are roster duties and my duty can be in any shift and the shift is not fixed.</li>
					<li>&nbsp;&nbsp;My home is equipped with adequate internet facilities.</li>
					<li>&nbsp;&nbsp;If I am finally selected for the position, Dhaka International University will provide me training, sufficient time and energy, co-operation and will also pay during that time. So, there will be at least 2 years of contract period that I will serve the company unless I get a Government Job or go to abroad.  Except above 2 situations, if I leave the job I will refund 2 months salary to university account as training expense.</li>
					<li>&nbsp;&nbsp;This is a sales and marketing job which is target oriented.</li>
					<li>&nbsp;&nbsp;I have no problem with phone calls when I will be on or off duty and to provide required information to the inquirer.</li>
					<li>I have no problem to access Facebook, Instagram, Live chat, whatsapp, IMO & Tele Marketing. </li>
					<li>&nbsp;&nbsp;I have no problem with dress-code at the office time. </li>
					<li>&nbsp;&nbsp;I have no problem to visit anywhere in Bangladesh for official purpose. </li>
				</ol><br>
				<p>I have discussed with my family members as well. So I and my family have no problem with the above terms and agreed there by. </p><br><br><br>		

			</td>			
		</tr>
		<tr>
			<td>
				<p>Signature:</p>	
				<p>Full Name:</p>	
				<p>Date:</p>	
				
			</td>
			
		</tr>
    </table>
</body>

</html>
