<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            margin: 20px 0;
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
            padding: 15px;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 20px 0;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{ $title }}
        </div>
        <div class="content">
            {!! $body !!}
        </div>

        @if(!empty($buttonText) && !empty($buttonUrl))
            <div style="text-align: center;">
                <a href="{{ $buttonUrl }}" class="button">{{ $buttonText }}</a>
            </div>
        @endif

        <div class="footer">
            <p>&copy; {{ date('Y') }} DataByteDigital. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
