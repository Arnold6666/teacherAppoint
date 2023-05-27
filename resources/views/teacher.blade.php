<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
                                <a class="nav-link active" aria-current="page" href="/create">新增文章<svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                        <path
                                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path
                                            d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
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

            <div class="col-12 m-auto mt-5 border p-4 border-info rounded">
                <div class="card mb-3 ">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src={{ asset(str_replace('/app/public', '', substr($teacher->image, 1))) }}
                                class="img-fluid rounded-start w-100" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $teacher->name }}</h5>
                                <p class="card-text d-flex align-items-center">
                                    {{ $teacher->stars }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg> &nbsp;
                                    ({{ $teacher->comments }})
                                </p>
                                <p class="card-text">{{ $teacher->intro }}</p>
                                <p>上課時間：</p>
                                <p class="ms-2">{{ $teacher->mon === 1 ? '星期一' : '' }}</p>
                                <p class="ms-2">{{ $teacher->tues === 1 ? '星期二' : '' }}</p>
                                <p class="ms-2">{{ $teacher->wed === 1 ? '星期三' : '' }}</p>
                                <p class="ms-2">{{ $teacher->thurs === 1 ? '星期四' : '' }}</p>
                                <p class="ms-2">{{ $teacher->fri === 1 ? '星期五' : '' }}</p>
                                <p class="ms-2">{{ $teacher->sat === 1 ? '星期六' : '' }}</p>
                                <p class="ms-2">{{ $teacher->sun === 1 ? '星期日' : '' }}</p>
                                <p>價格：{{ $teacher->price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <form action="/curruculum/create" method="post">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">一</th>
                                    <th scope="col">二</th>
                                    <th scope="col">三</th>
                                    <th scope="col">四</th>
                                    <th scope="col">五</th>
                                    <th scope="col">六</th>
                                    <th scope="col">日</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @php
                                    $startDate = Carbon::now()->startOfWeek(); // 取得當前禮拜的開始日期
                                    $endDate = $startDate->copy()->addWeeks(3); // 加上三個禮拜的日期
                                    $currentDate = $startDate->copy(); // 目前處理的日期
                                @endphp
                                @while ($currentDate <= $endDate)
                                    <tr>
                                        @for ($i = 0; $i < 7; $i++)
                                            <td class="text-center">
                                                <div class="btn-group mb-2 me-2" role="group"
                                                    aria-label="Basic checkbox toggle button group">
                                                    <input type="checkbox" class="btn-check"
                                                        id="{{ 'date' . $currentDate->format('d') }}"
                                                        autocomplete="off" name="hashtag_id[]"
                                                        value="{{ $currentDate->format('d') }}">
                                                    <label class="btn btn-outline-primary"
                                                        for="{{ 'hashtag' . $currentDate->format('d') }}">{{ $currentDate->format('d') }}</label>
                                                </div>
                                            </td>

                                            @php
                                                $currentDate->addDay(); // 前進一天
                                            @endphp
                                        @endfor
                                    </tr>
                                @endwhile
                            </tbody>
                    </form>
                </div>
            </div>
    </section>

    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
