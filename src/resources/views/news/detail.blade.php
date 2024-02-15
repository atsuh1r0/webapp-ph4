<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News 詳細</title>
</head>

<body>
    <main>
        <h1>News 詳細</h1>
        <div>
            <p>{{ $data['title'] }}</p>
            <p>{{ $data['text'] }}</p>
            <img src="{{ $data['thumbnail_url'] }}" alt="" width="400" height="300" />
            <p>{{ $data['date'] }}</p>
            <div>
                <p>著者</p>
                <p>{{ $data['author']['name'] }}</p>
                <img src="{{ $data['author']['picture_url'] }}" alt="" width="200" height="150">
            </div>
        </div>
    </main>
</body>

</html>
