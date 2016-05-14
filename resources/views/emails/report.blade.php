<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>MRN #{{ $report->id }} on {{ $app }}</title>
    </head>
    <body>
        <p>Hello {{ $report->user->name }},</p><br /><br />
        <p>Here is your MRN #{{ $report->id }} on {{ $app }}:</p><br />
        <p>
            <strong>Procedure</strong>&nbsp;{{ $report->procedure }}<br />
            <strong>Statement</strong>&nbsp;{{ $report->statement }}<br />
            <strong>Findings</strong>&nbsp;{{ $report->findings }}<br />
            <strong>Impression</strong>&nbsp;{{ $report->impression }}<br />
            <strong>Conclusion</strong><br />{{ $report->conclusion }}<br /><br />
            {{ date('F d, Y H:i', strtotime($report->created_at)) }}
        </p><br /><br />
        <p>Get well soon!</p>
    </body>
</html>
