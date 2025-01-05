<!DOCTYPE html>
<html>
<head>
    <title>Pastebins</title>
</head>
<body>
    <h1>Pastebins</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>URL</th>
                <th>Content</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pastebins as $pastebin)
                <tr>
                    <td>{{ $pastebin->id }}</td>
                    <td>{{ $pastebin->url }}</td>
                    <td>{{ $pastebin->content }}</td>
                    <td>{{ $pastebin->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $pastebins->links() }}
</body>
</html>