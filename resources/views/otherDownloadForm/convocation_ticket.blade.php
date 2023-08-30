<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocation</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        
        .absolute{
            position: absolute;
            left: 0;
            right: 0;
            top:0;
            width: 100px;
            margin:0 auto;
            border:1px solid green;
          }
    </style>
</head>

<body>
    <section style="display: grid;grid-template-columns: repeat(3,1fr); height: 100vh;">
        @foreach($details as $detail)
        <main style="position: relative; height: 100vh">

            <div style="position: absolute; right: 5%; top:2%; text-align: center; font-weight: bold;">
                <h4>{{$detail['Serial']}}</h4>
            </div>
            <img style="position: absolute; width:100%; height: 100%; left:0; top:0;" src="https://api.diu.ac//images/diuac/editorImage/1648396654_DGJpaMIqf1.png">
            <img style="position: absolute; left: 34%; top:11%; width: 15rem; height: 15rem; justify-content: center" src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->merge($detail['Image'], .4, true)
            ->size(512)->errorCorrection('H')
            ->generate(($detail['ID']))) !!} ">
            <div style="position: absolute; left: 40%; bottom:60%; text-align: center; font-weight: bold;">
                <h4>{{$detail['Name']}}</h4>
                <p>{{$detail['Registration']}}</p>
            </div>
            <img style="position: absolute; left: 34%; bottom:23%; width: 10rem; height: 10rem; transform: rotate(-90deg)" src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->merge($detail['Image'], .4, true)
            ->size(512)->errorCorrection('H')
            ->generate(($detail['ID']))) !!} ">
            <div style="position: absolute; left: 56%; bottom:30%; text-align: center; font-weight: bold; transform: rotate(-90deg)">
                <h4>{{$detail['Serial']}}</h4>
            </div>
            <div style="position: absolute; left: 26%; bottom:23%; width: 10rem; height: 10rem; transform: rotate(-90deg); font-size: .7rem;">
                <h4>{{$detail['Name']}}</h4>
                <p>{{$detail['Registration']}}</p>
            </div>
            <img style="position: absolute; left: 34%; bottom:2%; width: 10rem; height: 10rem; transform: rotate(-90deg)" src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->merge($detail['Image'], .4, true)
            ->size(512)->errorCorrection('H')
            ->generate(($detail['ID']))) !!} ">
            <div style="position: absolute; left: 26%; bottom:2%; width: 10rem; height: 10rem; transform: rotate(-90deg); font-size: .7rem;">
                <h4>{{$detail['Name']}}</h4>
                <p>{{$detail['Registration']}}</p>
            </div>

            <div style="position: absolute; left: 56%; bottom:9%; text-align: center; font-weight: bold; transform: rotate(-90deg)">
                <h4>{{$detail['Serial']}}</h4>
            </div>
        </main>
        @endforeach
    </section>
</body>

</html>