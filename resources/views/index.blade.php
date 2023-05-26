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
    <title>TeacherAppoint</title>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark px-5" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">TeacherAppoint</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @if ($user)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/create">新增文章<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                  </svg></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/hashtag">文章標籤</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/logout">登出</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="btn btn-outline-secondary mb-0 text-white ms-2"
                                    href="{{ route('myArticle') }}">{{ auth()->user()->name }} 的文章</a>
                            </li> --}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/login">登入</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/register">註冊帳號</a>
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
                </div>
            @endif
            <div class="col-10 m-auto mt-5 border p-4 border-info rounded">
                <form class="d-flex" role="search" action="">
                    @csrf
                    <select class="form-select" aria-label="Default select example">
                        <option selected>老師國籍選擇</option>
                        <option value="1">美國</option>
                        <option value="2">英國</option>
                        <option value="3">台灣</option>
                        <option value="4">香港</option>
                        <option value="5">印度</option>
                    </select>
                    <button class="btn btn-outline-primary" style="width:100px" type="submit">搜尋老師</button>
                </form>
                <hr>
                <h2 class="text-center">所有文章</h2>
            </div>
            <hr>
            <div class="col-12">
                <div class="card mb-3 " >
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="https://picsum.photos/300/300?random=1" class="img-fluid rounded-start w-100" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">Arnold.Smith</h5>
                                <p class="card-text"> 4.8 </p>
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <p class="card-text "><small class="text-body-secondary">Last updated 3 mins ago</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($teachers as $teacher)
                <div class="card mb-3 " >
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src={{asset(str_replace('/app/public', '',substr($teacher->image, 1)))}} class="img-fluid rounded-start w-100" alt="...">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{$teacher->name}}</h5>
                                <p class="card-text"> {{$teacher->stars}} ({{$teacher->comments}})</p>
                                <p class="card-text">{{$teacher->intro}}</p>
                                <p class="d-flex justify-content-around mb-0 align-items-center">
                                    <a href={{ '/teacher/' . $teacher->id }} class="btn btn-primary">擇時上課</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
