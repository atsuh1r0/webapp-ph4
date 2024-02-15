<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
</head>

<body>
    <main>
        <h1>News</h1>
        <div>
            @if (isset($error))
            <p>{{ $error }}</p>
            @else
            @foreach ($data as $news)
            <div>
                <p>{{ $news['title'] }}</p>
                <p>{{ $news['text'] }}</p>
                <img src="{{ $news['thumbnail_url'] }}" alt="" width="400" height="300" />
                <p>{{ $news['date'] }}</p>
                <div>
                    <p>著者</p>
                    <p>{{ $news['author']['name'] }}</p>
                    <img src="{{ $news['author']['picture_url'] }}" alt="" width="200" height="150">
                </div>
            </div>
            <a href="{{ route('news.detail', ['id' => $news['id']]) }}">詳細を見る</a>
            @endforeach
            @endif
        </div>

    </main>
</body>

</html>
