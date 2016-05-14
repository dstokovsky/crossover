<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ $app }} Pass Code</title>
    </head>
    <body>
        <p>Hello {{ $user->name }},</p><br /><br />
        <p>Here is credentials to access your medical records on {{ $app }}:</p><br />
        <p>
            <strong>Login:</strong>&nbsp;{{ $user->email }}<br />
            <strong>Password:</strong>&nbsp;{{ $passcode }}
        </p><br /><br />
        <p>Get well soon!</p>
    </body>
</html>
