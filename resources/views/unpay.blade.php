<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- bootstrap 5  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Appoint</title>

</head>

<body>
    <section>
        <div class="container">
            @if (Session::has('message'))
                <div class="alert alert-warning mt-5 text-center fs-3" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <div class="col-12 m-auto mt-5 border p-4 border-info rounded">
                <div>
                    <ul class="nav nav-tabs fs-5 justify-content-around" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100 active" id="state1-tab" data-bs-toggle="tab"
                                data-bs-target="#state1" type="button" role="tab" aria-controls="state1"
                                aria-selected="true">已預約</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        {{-- 已預約 --}}
                        <div class="tab-pane fade show active" id="state1" role="tabpanel" aria-labelledby="state1-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">編號</th>
                                        <th scope="col">日期</th>
                                        <th scope="col">時間</th>
                                        <th scope="col">老師</th>
                                        <th scope="col">價格</th>
                                        {{-- <th scope="col" class="text-center">取消</th> --}}
                                        <th scope="col" class="text-center">付款</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        @if ($curriculum->state->id === 1)
                                            <tr>
                                                <th scope="row">{{ $curriculum->uuid }}</th>
                                                <td>{{ $curriculum->date }}</td>
                                                <td>{{ $curriculum->time }}</td>
                                                <td>{{ $curriculum->teacher->name }}</td>
                                                <td>{{ $curriculum->price }}</td>
                                                {{-- <td class="text-center">
                                                    <form
                                                        action=""
                                                        method="POST" onsubmit="return confirm('確定要取消這個課程嗎？')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger"
                                                            type="submit">取消</button>
                                                    </form>
                                                </td> --}}
                                                <td class="text-center">
                                                    <form
                                                        action="/api/curriculum/pay"
                                                        method="POST" onsubmit="return confirm('確認前往付款？')">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" value="{{ $curriculum->uuid }}" name="uuid">
                                                        <button class="btn btn-outline-success"
                                                            type="submit">付款</button>
                                                    </form>
                                                </td>
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
