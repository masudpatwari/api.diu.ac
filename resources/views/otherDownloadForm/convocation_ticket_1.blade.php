<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Token</title>
</head>
<body>
    @php
        $url = env("APP_URL") . "images/no_image.jpg";
    @endphp
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr;">
        <div>
            <img src="{{env("APP_URL")}}.images/header.png">
            <div style="float: left;width: 55%;margin-left: 10px;">
                <table>
                    <tr>
                        <td class="b-none" style="text-align: right" >
                            {{--  @if($url)  --}}
                            <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                                    ->merge($url, 0.3, true)
                                    ->size(140)->errorCorrection('H')
                                    ->generate($details)) !!} ">
                            {{--  @endif  --}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div>
            {{--  <img src="{{asset('/header.png')}}">  --}}
            <div style="float: left;width: 55%;margin-left: 10px;">
                <table>
                    <tr>
                        <td class="b-none" style="text-align: right" >
                            {{--  @if($url)  --}}
                            <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                                    ->merge($url, 0.3, true)
                                    ->size(140)->errorCorrection('H')
                                    ->generate($details)) !!} ">
                            {{--  @endif  --}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div>
            {{--  <img src="{{asset('/header.png')}}">  --}}
            <div style="float: left;width: 55%;margin-left: 10px;">
                <table>
                    <tr>
                        <td class="b-none" style="text-align: right" >
                            {{--  @if($url)  --}}
                            <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                                    ->merge($url, 0.3, true)
                                    ->size(140)->errorCorrection('H')
                                    ->generate($details)) !!} ">
                            {{--  @endif  --}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
