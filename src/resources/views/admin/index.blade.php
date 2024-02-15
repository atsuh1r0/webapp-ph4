<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- @vite('resources/css/app.css') -->
</head>

<body>
    <h1>管理画面</h1>
    <p>管理者のみがアクセスできるページです。</p>
    <a href="{{ route('study_time.index') }}">勉強時間の入力画面へ</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>

    <main style="display: flex; gap:20px;">
        <div>
            <h2>ユーザー一覧</h2>
            <p>ユーザーの一覧を表示します。</p>
            <table>
                <thead>
                    <tr>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.user.delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>ユーザー新規作成</h3>
            <form method="POST" action="{{ route('admin.user.register') }}">
                @csrf
                <div>
                    <label for="name">名前</label>
                    <input id="name" type="text" name="name" required autofocus>
                </div>
                <div>
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" required>
                </div>
                <div>
                    <label for="password">パスワード</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
                <div>
                    <label for="is_admin">権限</label>
                    <select id="is_admin" name="is_admin">
                        <option value="0">一般ユーザー</option>
                        <option value="1">管理者</option>
                    </select>
                </div>
                <button type="submit">登録</button>
            </form>
        </div>
        <div>
            <h2>学習言語管理</h2>
            <p>学習言語の一覧を表示します。</p>
            <table>
                <thead>
                    <tr>
                        <th>言語名</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($languages as $language)
                    <tr>
                        <td>{{ $language->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.language.delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $language->id }}">
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <h2>学習コンテンツ管理</h2>
            <p>学習コンテンツの一覧を表示します。</p>
            <table>
                <thead>
                    <tr>
                        <th>コンテンツ名</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contents as $content)
                    <tr>
                        <td>{{ $content->name }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.content.delete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $content->id }}">
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if(session('success_user_register'))
    <script>
        toastr.success('新たなユーザーを登録しました。');
    </script>
    @endif
    @if(session('error_user_register'))
    <script>
        toastr.error('ユーザーの登録に失敗しました。');
    </script>
    @endif
    @if(session('success_user_delete'))
    <script>
        toastr.success('ユーザーを削除しました。');
    </script>
    @endif
    @if(session('error_user_delete'))
    <script>
        toastr.error('ユーザーの削除に失敗しました。');
    </script>
    @endif
    @if(session('success_language_delete'))
    <script>
        toastr.success('言語を削除しました。');
    </script>
    @endif
    @if(session('error_language_delete'))
    <script>
        toastr.error('言語の削除に失敗しました。');
    </script>
    @endif
</body>

</html>
