<!DOCTYPE html>
<html>
<head>
    <title>New Pastebins Notification</title>
</head>
<body>
    <h1>New Pastebins detected on date: {{ $datetime }}</h1>
    <ul>
        @foreach ($newPastebins as $pastebin)
            <li>
                <strong>URL:</strong> {{ $pastebin['url'] }}<br>
                <strong>Content:</strong> {{ $pastebin['content'] }}
                @if (count($pastebin['existing_content_pastebins']))
                    <ul>
                        <strong>Already existing at:</strong>
                        @foreach ($pastebin['existing_content_pastebins'] as $existingPastebin)
                            <li>
                                {{ $existingPastebin['url'] }} from date {{ $existingPastebin['created_at'] }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
            <br>
        @endforeach
    </ul>

    @if ($latestPastebins && count($latestPastebins))
        <h2>Latest pastebins...</h2>
        <ul>
            @foreach ($latestPastebins as $latestPastebin)
                <li>
                    <strong>URL:</strong> {{ $latestPastebin['url'] }}<br>
                    <strong>Content:</strong> {{ $latestPastebin['content'] }}<br>
                    <strong>Created At:</strong> {{ \Carbon\Carbon::parse($latestPastebin['created_at'])
                                                        ->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s')}}
                </li>
                <br>
            @endforeach
        </ul>
    @endif
</body>
</html>