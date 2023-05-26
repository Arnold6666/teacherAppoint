<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- bootstrap 5  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Blog</title>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark px-5" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @if ($user)
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/create">新增文章<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                  </svg></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/logout">登出</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="btn btn-outline-secondary mb-0 text-white ms-2" href="{{ route('myArticle')}}">{{ auth()->user()->name }} 的文章 </a>
                            </li> --}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/register">註冊帳號</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section>
        <div class="container">
            @if (Session::has('message'))
                <div class="alert alert-warning mt-5 text-center fs-3" role="alert">
                    {{ Session::get('message') }}
                    @if (Session::has('message') && Session::get('status') === true)
                        <a href="/login" class="text-de">登入</a>
                    @endif
                </div>
            @endif

            <div class="col-6 m-auto mt-5 border p-4 border-info rounded">
                <form action="/register" method="post">
                    @csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="name" class="form-label">您的大名</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">信箱(將作為帳號)</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密碼</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">再次輸入密碼</label>
                        <input type="password" class="form-control" id="password2" name="password2"
                            value="{{ old('password2') }}" required>
                    </div>
                    <p class="text-center mb-0">
                        <button type="submit" class="btn btn-primary w-50">註冊</button>
                    </p>
                </form>
            </div>
        </div>
    </section>

    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
