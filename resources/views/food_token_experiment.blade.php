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
    <section style="display: grid;grid-template-columns: repeat(8,1fr)">
        @foreach($details as $detail)
        <main style="position: relative; height: 50vh">

            <div style="position: absolute; left: 56%; top:2%; text-align: center; font-size: .8rem; z-index:1">
                <h6>{{$detail['Serial']}}</h6>
            </div>
            <img style="position: absolute; width: 100%;height: 100%; left:0; top:0;" src="https://api.diu.ac/images/diuac/editorImage/1649139845_PFeLbUL9Eq.jpg">
            <img style="position: absolute; left: 7%; top:28%; width: 7rem; height: 7rem; justify-content: center" src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            ->merge($detail['Image'], .4, true)
            ->size(512)->errorCorrection('H')
            ->generate(($detail['Url']))) !!} ">
            <div style="position: absolute; left: 6%; top:60%; text-align: center; font-size: .76rem;">
                <h4>{{$detail['Name']}}</h4>
                <p>{{$detail['Registration']}}</p>
            </div>
        </main>
        @endforeach
    </section>
{{--    <section style="display: grid;grid-template-columns: repeat(8,1fr)">--}}
{{--        @foreach($details as $detail)--}}
{{--            <main style="position: relative; height: 50vh">--}}

{{--                <div style="position: absolute; left: 56%; top:2%; text-align: center; font-size: .8rem; z-index:1">--}}
{{--                    <h6>{{$detail['Serial']}}</h6>--}}
{{--                </div>--}}
{{--                <img style="position: absolute; width: 100%;height: 100%; left:0; top:0;" src="https://api.diu.ac/images/diuac/editorImage/1649139845_PFeLbUL9Eq.jpg">--}}
{{--                <img style="position: absolute; left: 7%; top:28%; width: 7rem; height: 7rem; justify-content: center" src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')--}}
{{--            ->merge($detail['Image'], .4, true)--}}
{{--            ->size(512)->errorCorrection('H')--}}
{{--            ->generate(($detail['Url']))) !!} ">--}}
{{--                <div style="position: absolute; left: 6%; top:60%; text-align: center; font-size: .76rem;">--}}
{{--                    <h4>{{$detail['Name']}}</h4>--}}
{{--                    <p>{{$detail['Registration']}}</p>--}}
{{--                </div>--}}
{{--            </main>--}}
{{--        @endforeach--}}
{{--    </section>--}}
</body>

</html>