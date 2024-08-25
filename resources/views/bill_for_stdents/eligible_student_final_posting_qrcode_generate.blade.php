<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>

<body>





    

    <div style="width: 100%">   
    
     @foreach ($data as $item ) 
     @php
         $url = 'https://cms.diu.ac/eligible-scholarship-final-posting/'.$item['student_id'];
    $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
    ->size(280)
    ->errorCorrection('H')
    ->generate($url));
     @endphp         
        
     <div style="width: 24.7%;float: left;border:1px solid #afacac;text-align: center;">
         <div style="margin-top:10px"> 
             <span style="font-size: 10px;margin-bottom:-10px">{{$item['name']}}</span><br>
             <span style="font-size: 11px">{{$item['reg_code']}}</span><br>
             <strong style="font-size: 16px">{{$item['student_id']}}</strong>
         </div>
         <div style=" margin-bottom:20px">
            <img style="height: 141px;" src="data:image/png;base64, {!! $qrCode !!}">
         </div>
     </div>
     @endforeach
        
       
      
        
     
        




    </div>
    




</body>

</html>
