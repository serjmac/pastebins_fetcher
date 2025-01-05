<!DOCTYPE html>
<html>
<head>
    <title>Errors</title>
</head>
<body>
    <h1>Errors</h1>
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
            @foreach ($errors as $error)
                <tr>
                    <td>{{ $error->id }}</td>
                    <td>{{ $error->url }}</td>
                    <td>{{ $error->error }}</td>
                    <td>{{ $error->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $errors->links() }}
</body>
</html>