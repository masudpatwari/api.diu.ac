<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dhaka International University.</title>

    <style>
        .alert {
            padding: 20px;
            color: #FFFFFF;
            text-align: center;
        }
        .success{
            background-color: #4CAF50;
        }
        .danger{
            background-color: #f44336;
        }
        .info{
            background-color: #2196F3;
        }
    </style>
</head>
<body>

<div style="max-width: 400px;margin: 0 auto;margin-top: 40px;">
    <div class="alert {{ $code == '401' ? 'danger' : '' }} {{ $code == '402' ? 'info' : '' }} {{ $code == '200' ? 'success' : '' }}">
        {{ $message ?? 'N/A' }}
    </div>
</div>

</body>
</html>