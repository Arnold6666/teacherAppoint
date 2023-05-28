<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $student = Auth::user()->id;

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        try {
            foreach ($request->datetime as $datetime) {
                $curriculum     = new Curriculum;
                $date = Carbon::parse($datetime);

                $curriculum->teacher    = $request->teacher;
                $curriculum->student    = $student;
                $curriculum->date       = $date->format('Y-m-d');
                $curriculum->time       = $date->format('H:i:s');
                $curriculum->price      = $request->price;
                $curriculum->created_at = $dateTimeStr;
                $curriculum->updated_at = $dateTimeStr;
                $curriculum->save();
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status'    => false,
                'message'   => $th->getMessage()
            ], 500);
        }


        return print_r($request->datetime);
        // return
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $user = Auth::user()->id;

        $curriculums = Curriculum::with('teacher')->with('state')
            ->where('student_id', $user)
            ->orderBy('date')
            ->get();

        // foreach($curriculums as $curriculum){
        //     print_r($curriculum->teacher);
        // }

        return view('mycourse', compact('curriculums'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $curriculum = Curriculum::findOrFail($id);
        $dateTimeStr    = Carbon::now()->toDateTimeString();

        // 根據表單資料更新 Curriculum

        try {
            $validator = validator::make(
                $request->all(),
                [
                    'stars'     => 'required',
                ],
                [
                    'stars.required'   => '請選擇評分',
                ]
            );
            $errors = $validator->errors()->all();

            $message = "";

            for ($i = 0; $i < count($errors); $i++) {
                if ($i === count($errors) - 1) {
                    $message = $message . $errors[$i];
                    continue;
                }
                $message = $message . $errors[$i] . '，';
            }

            if ($validator->fails()) {
                session()->flash('message', $message);
                return redirect()->back();
            }

            $curriculum->stars = $request->stars;
            $curriculum->comment = $request->comment;
            $curriculum->updated_at = $dateTimeStr;
            $curriculum->state_id = 4;
            $curriculum->save();

            return redirect()->back()->with('message', '評價成功');
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->state_id = 6;
        $curriculum->updated_at = Carbon::now()->toDateTimeString();
        $curriculum->save();

        return redirect()->back()->with('message', '課程已成功刪除');
    }

    public function refund(Request $request)
    {
        
        $curriculum = Curriculum::findOrFail($request->id);
        $curriculum->state_id = 7;
        $curriculum->updated_at = Carbon::now()->toDateTimeString();
        $curriculum->save();

        return redirect()->back()->with('message', '已進入退款處理程序');
    }
}
