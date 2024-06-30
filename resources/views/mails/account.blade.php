<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        .container {
            width: 100%;
            padding: 0;
            margin: 0;
            font-family: "Helvetica", "Arial", sans-serif;
        }

        .header, .footer {
            color: white;
            background-color: rgb(33, 37, 41);
            padding: 15px 0;
            text-align: center;
        }

        .header h1 {
            font-size: 30px;
        }

        .body {
            padding: 30px 10%;
        }

        .body p {
            opacity: 0.7;
            text-align: center;
        }

        .button {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 15px;
            width: 100%;
            font-size: 110%;
        }

        .button:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Factory dashboard</h1>
    </div>
    <div class="body">
        <p style="margin-bottom: 15px">
            Hello, <strong>{{$user->first_name}} {{$user->last_name}}</strong>!
        </p>

        <p>
            We are pleased to inform you that an administrator has created an account for you on our system. To log in,
            please use the following credentials:
        </p>

        <p style="text-align: left">
            <strong>Email</strong>: {{ $user->email }}<br>
            <strong>Password</strong>: password<br>
        </p>

        <a href="{{ $request->url() }}" target="_blank" style="text-decoration: none">
            <div class="button">
                Login to dashboard
            </div>
        </a>


    </div>
    <div class="footer">
        Account created {{ date("H:i:s") }}, {{ date("d.m.Y") }}
    </div>
</div>
</body>
</html>
