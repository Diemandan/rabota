<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Логи ответов банка</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            max-height: 500px;
            overflow-y: scroll;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Логи ответов банка</h1>

    <pre>{{ $paymentContents }}</pre>
</div>

</body>
</html>

