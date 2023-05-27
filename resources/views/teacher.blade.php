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
                                <a class="nav-link d-flex align-items-center btn btn-outline-secondary"
                                    aria-current="page" href="/create">我的課表<svg xmlns="http://www.w3.org/2000/svg"
                                        width="20" height="20" class="ms-1" fill="currentColor"
                                        class="bi bi-card-checklist" viewBox="0 0 16 16">
                                        <path
                                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path
                                            d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                                    </svg></a>
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
                    @if (Session::has('message') && Session::get('status') === true)
                        <a href="/login" class="text-de">登入</a>
                    @endif
                </div>
            @endif

            <div class="col-12 m-auto mt-5 border p-4 border-info rounded">
                <div class="card mb-3 ">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src={{ asset('storage' . str_replace('public', '', $teacher->image)) }}
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
                                <p class="ms-2">{{ $teacher->monday === 1 ? '星期一' : '' }}</p>
                                <p class="ms-2">{{ $teacher->tuesday === 1 ? '星期二' : '' }}</p>
                                <p class="ms-2">{{ $teacher->wednesday === 1 ? '星期三' : '' }}</p>
                                <p class="ms-2">{{ $teacher->thursday === 1 ? '星期四' : '' }}</p>
                                <p class="ms-2">{{ $teacher->friday === 1 ? '星期五' : '' }}</p>
                                <p class="ms-2">{{ $teacher->saturday === 1 ? '星期六' : '' }}</p>
                                <p class="ms-2">{{ $teacher->sunday === 1 ? '星期日' : '' }}</p>
                                <p>價格：{{ $teacher->price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <form action="/curriculum/create" method="post" id="curruculum">
                        @csrf
                        {{-- <table class="table">
                            <thead>
                                <tr class="text-center">
                                    @php
                                        $currentDate = Carbon::now()->addDay(1);
                                        $count = 0;
                                        $availableDays = collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                                            ->filter(function ($day) use ($teacher) {
                                                return $teacher->{$day} === 1;
                                            })
                                            ->toArray();
                                    @endphp
                                
                                    @while ($count < 7)
                                        @if (in_array(strtolower($currentDate->englishDayOfWeek), $availableDays))
                                            <th scope="col">{{ $currentDate->format('Y-m-d') }}</th>
                                            @php
                                                $count++;
                                            @endphp
                                        @endif
                                
                                        @php
                                            $currentDate->addDay();
                                        @endphp
                                    @endwhile
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @php
                                    $startTime = Carbon::createFromTime(8, 0, 0);
                                    $endTime = Carbon::createFromTime(21, 0, 0);
                                    
                                    $currentDate = Carbon::now()->addDay();
                                    $endDate = $currentDate->copy()->addDay(7);
                                    $curriculumsCollection = collect($teacher->curriculums);
                                @endphp

                                @while ($startTime <= $endTime)
                                    <tr>
                                        @php
                                            $columnDate = $currentDate->copy();
                                        @endphp

                                        @for ($j = 0; $j < 7; $j++)
                                            @php
                                                $buttonDate = $columnDate->copy()->setTimeFromTimeString($startTime->format('H:i:s'));
                                                $buttonId = 'date' . $buttonDate->format('YmdHis');
                                            @endphp

                                            <td class="text-center">
                                                <div class="btn-group" role="group"
                                                    aria-label="Basic checkbox toggle button group">
                                                    <input type="checkbox" class="btn-check" id="{{ $buttonId }}"
                                                        autocomplete="off" name="datetime[]"
                                                        value="{{ $buttonDate->format('Y-m-d H:i:s') }}"
                                                        {{ $curriculumsCollection->contains(function ($curriculum) use ($buttonDate) {
                                                            return $curriculum->date == $buttonDate->toDateString() && $curriculum->time == $buttonDate->toTimeString();
                                                        }) ||
                                                        ($buttonDate->isSunday() && !$teacher->sunday) ||
                                                        ($buttonDate->isMonday() && !$teacher->monday) ||
                                                        ($buttonDate->isTuesday() && !$teacher->tuesday) ||
                                                        ($buttonDate->isWednesday() && !$teacher->wednesday) ||
                                                        ($buttonDate->isThursday() && !$teacher->thursday) ||
                                                        ($buttonDate->isFriday() && !$teacher->friday) ||
                                                        ($buttonDate->isSaturday() && !$teacher->saturday)
                                                            ? 'disabled'
                                                            : '' }}>
                                                    <label class="btn btn-outline-primary disable"
                                                        for="{{ $buttonId }}">
                                                        {{ $buttonDate->format('H:i') }}
                                                    </label>
                                                </div>
                                            </td>

                                            @php
                                                $columnDate->addDay();
                                            @endphp
                                        @endfor

                                        @php
                                            $startTime->addHour();
                                        @endphp
                                    </tr>
                                @endwhile
                            </tbody>
                        </table> --}}

                        {{-- <table class="table">
                            <thead>
                                <tr class="text-center">
                                    @php
                                        $currentDate = Carbon::now()->addDay();
                                        $dayOfWeek = $currentDate->dayOfWeek; // 當前日期的星期幾 (0-6，0 表示星期日)
                                    @endphp
                        
                                    @for ($i = 0; $i < 7; $i++)
                                        <th scope="col">
                                            {{ $currentDate->format('Y-m-d') }}
                                            @php
                                                $currentDate->addDay();
                                            @endphp
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @php
                                    $startTime = Carbon::createFromTime(8, 0, 0);
                                    $endTime = Carbon::createFromTime(21, 0, 0);
                                    $currentDate = Carbon::now()->addDay();
                                    $endDate = $currentDate->copy()->addDay(7);
                                    $curriculumsCollection = collect($teacher->curriculums);
                                @endphp
                        
                                @while ($startTime <= $endTime)
                                    <tr>
                                        @php
                                            $columnDate = $currentDate->copy();
                                        @endphp
                        
                                        @for ($j = 0; $j < 7; $j++)
                                            @php
                                                $buttonDate = $columnDate->copy()->setTimeFromTimeString($startTime->format('H:i:s'));
                                                $buttonId = 'date' . $buttonDate->format('YmdHis');
                                            @endphp
                        
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                                    <input type="checkbox" class="btn-check" id="{{ $buttonId }}"
                                                        autocomplete="off" name="datetime[]"
                                                        value="{{ $buttonDate->format('Y-m-d H:i:s') }}"
                                                        {{ $curriculumsCollection->contains(function ($curriculum) use ($buttonDate) {
                                                                return $curriculum->date == $buttonDate->toDateString() && $curriculum->time == $buttonDate->toTimeString();
                                                            }) ||
                                                            ($j === $dayOfWeek && !$teacher->{strtolower($buttonDate->englishDayOfWeek)})
                                                            ? 'disabled'
                                                            : '' }}>
                                                    <label class="btn btn-outline-primary disable" for="{{ $buttonId }}">
                                                        {{ $buttonDate->format('H:i') }}
                                                    </label>
                                                </div>
                                            </td>
                        
                                            @php
                                                $columnDate->addDay();
                                            @endphp
                                        @endfor
                        
                                        @php
                                            $startTime->addHour();
                                        @endphp
                                    </tr>
                                @endwhile
                            </tbody>
                        </table> --}}
                        <input type="hidden" value={{ request()->segment(2) }} name="teacher">
                        <input type="hidden" value={{ $teacher->price }} name="price">

                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    @php
                                        $currentDate = Carbon::now()->addDay(1);
                                        $count = 0;
                                        $availableDays = collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                                            ->filter(function ($day) use ($teacher) {
                                                return $teacher->{$day} === 1;
                                            })
                                            ->toArray();
                                    @endphp

                                    @while ($count < 7)
                                        @if (in_array(strtolower($currentDate->englishDayOfWeek), $availableDays))
                                            <th scope="col">{{ $currentDate->format('Y-m-d') }}</th>
                                            @php
                                                $count++;
                                            @endphp
                                        @endif

                                        @php
                                            $currentDate->addDay();
                                        @endphp
                                    @endwhile
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @php
                                    $startTime = Carbon::createFromTime(8, 0, 0);
                                    $endTime = Carbon::createFromTime(21, 0, 0);
                                    
                                    $currentDate = Carbon::now()->addDay();
                                    $endDate = $currentDate->copy()->addDay(7);
                                    $curriculumsCollection = collect($teacher->curriculums);
                                @endphp

                                @while ($startTime <= $endTime)
                                    <tr>
                                        @php
                                            $columnDate = $currentDate->copy();
                                            $count = 0;
                                            $availableDays = collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                                                ->filter(function ($day) use ($teacher) {
                                                    return $teacher->{$day} === 1;
                                                })
                                                ->toArray();
                                        @endphp

                                        @for ($j = 0; $j < 7; $j++)
                                            @php
                                                $columnDate = $currentDate->copy();
                                                $count = 0;
                                                $availableDays = collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                                                    ->filter(function ($day) use ($teacher) {
                                                        return $teacher->{$day} === 1;
                                                    })
                                                    ->toArray();
                                            @endphp

                                            @for ($j = 0; $j < 7; $j++)
                                                @php
                                                    while (!in_array(strtolower($columnDate->englishDayOfWeek), $availableDays)) {
                                                        $columnDate->addDay();
                                                    }
                                                    
                                                    $buttonDate = $columnDate->copy()->setTimeFromTimeString($startTime->format('H:i:s'));
                                                    $buttonId = 'date' . $buttonDate->format('YmdHis');
                                                    $buttonValue = $columnDate->format('Y-m-d H:i:s');
                                                    $columnDate->addDay();
                                                @endphp

                                                <td class="text-center">
                                                    <div class="btn-group" role="group"
                                                        aria-label="Basic checkbox toggle button group">
                                                        <input type="checkbox" class="btn-check"
                                                            id="{{ $buttonId }}" autocomplete="off"
                                                            name="datetime[]" value="{{ $buttonDate }}"
                                                            {{ $curriculumsCollection->contains(function ($curriculum) use ($buttonDate) {
                                                                return $curriculum->date == $buttonDate->toDateString() && $curriculum->time == $buttonDate->toTimeString();
                                                            }) ||
                                                            ($buttonDate->isSunday() && !$teacher->sunday) ||
                                                            ($buttonDate->isMonday() && !$teacher->monday) ||
                                                            ($buttonDate->isTuesday() && !$teacher->tuesday) ||
                                                            ($buttonDate->isWednesday() && !$teacher->wednesday) ||
                                                            ($buttonDate->isThursday() && !$teacher->thursday) ||
                                                            ($buttonDate->isFriday() && !$teacher->friday) ||
                                                            ($buttonDate->isSaturday() && !$teacher->saturday)
                                                                ? 'disabled'
                                                                : '' }}>
                                                        <label class="btn btn-outline-primary disable"
                                                            for="{{ $buttonId }}">
                                                            {{ $buttonDate->format('H:i') }}
                                                        </label>
                                                    </div>
                                                </td>
                                            @endfor

                                            @php
                                                $columnDate->addDay();
                                            @endphp
                                        @endfor

                                        @php
                                            $startTime->addHour();
                                        @endphp
                                    </tr>
                                @endwhile
                            </tbody>
                        </table>


                        <div class="mt-3">
                            <p class="text-center">
                                <button class="btn btn-outline-primary w-25"
                                    onclick="{{ $user ? 'createCurriculum()' : 'alert(\'請先登入\')' }}">送出</button>
                            </p>
                        </div>
                    </form>
                </div>

            </div>
    </section>
    <script>
        function createCurriculum() {
            document.getElementbyId("curruculum").submit();
        }
    </script>
    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
