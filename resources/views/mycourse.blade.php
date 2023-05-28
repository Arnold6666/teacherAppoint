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
                                <a class="nav-link" aria-current="page" href="/logout">登出</a>
                            </li>
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

            <div class="col-12 m-auto mt-5 border p-4 border-info rounded">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-12">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $user->name }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <ul class="nav nav-tabs fs-5 justify-content-around" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100 " id="state1-tab" data-bs-toggle="tab"
                                data-bs-target="#state1" type="button" role="tab" aria-controls="state1"
                                aria-selected="true">已預約</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="state2-tab" data-bs-toggle="tab" data-bs-target="#state2"
                                type="button" role="tab" aria-controls="state2" aria-selected="true">已付款</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="state3-tab" data-bs-toggle="tab" data-bs-target="#state3"
                                type="button" role="tab" aria-controls="state3" aria-selected="true">已上課</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="state4-tab" data-bs-toggle="tab" data-bs-target="#state4"
                                type="button" role="tab" aria-controls="state4" aria-selected="true">已評論</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="state5-tab" data-bs-toggle="tab" data-bs-target="#state5"
                                type="button" role="tab" aria-controls="state5" aria-selected="true">已缺課</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="state6-tab" data-bs-toggle="tab"
                                data-bs-target="#state6" type="button" role="tab" aria-controls="state6"
                                aria-selected="true">已取消</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="state7-tab" data-bs-toggle="tab"
                                data-bs-target="#state7" type="button" role="tab" aria-controls="state7"
                                aria-selected="true">退款中</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100 active" id="state8-tab" data-bs-toggle="tab"
                                data-bs-target="#state8" type="button" role="tab" aria-controls="state8"
                                aria-selected="true">已退款</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        {{-- 已預約 --}}
                        <div class="tab-pane fade" id="state1" role="tabpanel" aria-labelledby="state1-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                        <th scope="col" class="text-center">取消</th>
                                        <th scope="col" class="text-center">付款</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 1)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('curriculum.destroy', ['id' => $curriculum->id]) }}"
                                                        method="POST" onsubmit="return confirm('確定要取消這個課程嗎？')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger"
                                                            type="submit">取消</button>
                                                    </form>
                                                </td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('curriculum.destroy', ['id' => $curriculum->id]) }}"
                                                        method="POST" onsubmit="return confirm('確定要取消這個課程嗎？')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger"
                                                            type="submit">取消</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 已付款 --}}
                        <div class="tab-pane fade" id="state2" role="tabpanel" aria-labelledby="state2-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                        <th scope="col" class="text-center">取消並退款</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 2)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                                <td class="text-center">
                                                    <form
                                                        action="{{ route('curriculum.refund', ['id' => $curriculum->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('確定要取消這個課程嗎？退款需等候20個工作日，並扣除手續費喔!')">
                                                        @csrf
                                                        @method('POST')
                                                        <button class="btn btn-outline-danger"
                                                            type="submit">取消並退款</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 未評論 --}}
                        <div class="tab-pane fade" id="state3" role="tabpanel" aria-labelledby="state3-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                        <th scope="col" class="text-center">取消</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 3)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="{{ '#curriculum' . $curriculum->id }}">
                                                        編輯
                                                    </button>

                                                    <div class="modal fade" id="{{ 'curriculum' . $curriculum->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header d-block">
                                                                    <p class="text-end mb-0"><button type="button"
                                                                            class="btn-close" data-bs-dismiss="modal"
                                                                            aria-label="Close"></button></p>

                                                                    <h1 class="modal-title fs-5">課程評論</h1>
                                                                    <h1 class="modal-title fs-6">
                                                                        老師：{{ $curriculum->teacher->name }}</h1>
                                                                    <h1 class="modal-title fs-6">
                                                                        上課時間：{{ $curriculum->date }}&nbsp;{{ $curriculum->time }}
                                                                    </h1>
                                                                </div>
                                                                <form
                                                                    action="{{ route('curriculum.update', ['id' => $curriculum->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="modal-body">
                                                                        <div class="d-flex">
                                                                            <h5>星數：&nbsp;</h5>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="stars"
                                                                                    id="stars5" value="5"
                                                                                    checked>
                                                                                <label class="form-check-label"
                                                                                    for="stars5">
                                                                                    5
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check ms-2">
                                                                                <input class="form-check-input"
                                                                                    type="radio" value="4"
                                                                                    name="stars" id="stars4">
                                                                                <label class="form-check-label"
                                                                                    for="stars4">
                                                                                    4
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check ms-2">
                                                                                <input class="form-check-input"
                                                                                    type="radio" value="3"
                                                                                    name="stars" id="stars3">
                                                                                <label class="form-check-label"
                                                                                    for="stars3">
                                                                                    3
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check ms-2">
                                                                                <input class="form-check-input"
                                                                                    type="radio" value="2"
                                                                                    name="stars" id="stars2">
                                                                                <label class="form-check-label"
                                                                                    for="stars2">
                                                                                    2
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check ms-2">
                                                                                <input class="form-check-input"
                                                                                    type="radio" value="1"
                                                                                    name="stars" id="stars1">
                                                                                <label class="form-check-label"
                                                                                    for="stars1">
                                                                                    1
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-floating mx-2">
                                                                        <textarea class="form-control" placeholder="評價" id="comment" name="comment" style="resize: none; height:200px"></textarea>
                                                                        <label for="comment">評價</label>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-around">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal">取消</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">送出</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 已評論 --}}
                        <div class="tab-pane fade" id="state4" role="tabpanel" aria-labelledby="state4-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                        <th scope="col">評分</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 4)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                                <td>{{ $curriculum->stars }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 已缺課 --}}
                        <div class="tab-pane fade" id="state5" role="tabpanel" aria-labelledby="state5-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 5)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 已取消 --}}
                        <div class="tab-pane fade" id="state6" role="tabpanel" aria-labelledby="state6-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 6)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 退款中 --}}
                        <div class="tab-pane fade" id="state7" role="tabpanel"
                            aria-labelledby="state7-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">退款金額(原金額 * 0.8)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 7)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price * 0.8 }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- 已退款 --}}
                        <div class="tab-pane fade show active" id="state8" role="tabpanel"
                            aria-labelledby="state8-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">退款金額(原金額 * 0.8)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 8)
                                            <tr>
                                                <th scope="row">{{ $curriculum->id }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price * 0.8 }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
