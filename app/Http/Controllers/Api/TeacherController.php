<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $teachers = Teacher::get();

            $formattedMessages = $teachers->map(function ($message) {
                return [
                    'id' => $message->id,
                    'name' => $message->name,
                    'image' => $message->image,
                    'intro' => $message->intro,
                    'country' => $message->country,
                    'monday' => $message->monday,
                    'tuesday' => $message->tuesday,
                    'wednesday' => $message->wednesday,
                    'thursday' => $message->thursday,
                    'friday' => $message->friday,
                    'saturday' => $message->saturday,
                    'sunday' => $message->sunday,
                    'price' => $message->price,
                    'stars' => $message->stars,
                    'comment' => $message->comment,
                ];
            });

            return response()->json([
                'status'    => true,
                'message'   => $formattedMessages
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => true,
                'message'   => $formattedMessages,
                // 'error'     => $th->getMessage(),
                // 'trace'     => $th->getTraceAsString()
            ], 404);
        }


        return view('index', compact('teachers'));
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

        try {
            $validate = validator::make($request->all(), [
                'name'      => 'required',
                'image'     => 'required',
                'intro'     => 'required',
                'country'   => 'required',
                'email'     => 'required|unique:teachers,email',
                'price'     => 'required',
            ]);

            //失敗後回傳並終止
            if ($validate->fails()) {

                $errors = $validate->errors()->all();
                $message = "";

                for ($i = 0; $i < count($errors); $i++) {
                    if ($i === count($errors) - 1) {
                        $message = $message . $errors[$i];
                        continue;
                    }
                    $message = $message . $errors[$i] . '，';
                }

                return response()->json([
                    'status'    => false,
                    'message'   => $message
                ], 404);
            }

            $teacher = new Teacher;
            $teacher->name = $request->name;
            $teacher->intro = $request->intro;
            $teacher->country = $request->country;
            $teacher->email = $request->email;
            $teacher->price = $request->price;
            $teacher->monday = $request->monday === null ? 0 : $request->monday;
            $teacher->tuesday = $request->tuesday === null ? 0 : $request->monday;
            $teacher->wednesday = $request->wednesday === null ? 0 : $request->monday;
            $teacher->thursday = $request->thursday === null ? 0 : $request->monday;
            $teacher->friday = $request->friday === null ? 0 : $request->monday;
            $teacher->saturday = $request->saturday === null ? 0 : $request->monday;
            $teacher->sunday = $request->sunday === null ? 0 : $request->monday;

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imagePath = $imageFile->store('public/teachers');
                $teacher->image = $imagePath;
            }

            $teacher->save();

            return response()->json([
                'status'    => true,
                'message'   => "新增老師資料成功"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => false,
                'message'   => '發生錯誤',
                'error'     => $th->getMessage(),
                'trace'     => $th->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $teacher = Teacher::where('id', $id)->with('curriculums')->first();

            $curriculums = $teacher->curriculums->map(function ($curriculum) {
                return [
                    'id'        => $curriculum->id,
                    'date'      => $curriculum->date,
                    'time'      => $curriculum->time,
                ];
            });

            $formattedMessages = [
                'id'        => $teacher->id,
                'name'      => $teacher->name,
                'image'     => $teacher->image,
                'intro'     => $teacher->intro,
                'country'   => $teacher->country,
                'monday'    => $teacher->monday,
                'tuesday'   => $teacher->tuesday,
                'wednesday' => $teacher->wednesday,
                'thursday'  => $teacher->thursday,
                'friday'    => $teacher->friday,
                'saturday'  => $teacher->saturday,
                'sunday'    => $teacher->sunday,
                'price'     => $teacher->price,
                'stars'     => $teacher->stars,
                'comment'   => $teacher->comment,
                'currirulum' => $curriculums
            ];

            return response()->json([
                'status'    => true,
                'message'   => $formattedMessages
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'status'    => false,
                'message'   => "發生錯誤",
                'error'     => $th->getMessage(),
                'trace'     => $th->getTraceAsString()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {

            $teacher = Teacher::where('id', $id)->first();
            if(!$teacher){
                return response()->json([
                    'status' => false,
                    'message' => 'Teacher not found'
                ], 404);
            }

            $teacher->name      = $request->has('name') ? $request->name : $teacher->name;
            $teacher->intro     = $request->has('intro') ? $request->intro : $teacher->intro;
            $teacher->country   = $request->has('country') ? $request->country : $teacher->country;
            $teacher->email     = $request->has('email') ? $request->email : $teacher->email;
            $teacher->price     = $request->has('price') ? $request->price : $teacher->price;
            $teacher->monday    = $request->has('monday') ? $request->monday : $teacher->monday;
            $teacher->tuesday   = $request->has('tuesday') ? $request->tuesday : $teacher->tuesday;
            $teacher->wednesday = $request->has('wednesday') ? $request->wednesday : $teacher->wednesday;
            $teacher->thursday  = $request->has('thursday') ? $request->thursday : $teacher->thursday;
            $teacher->friday    = $request->has('friday') ? $request->friday : $teacher->friday;
            $teacher->saturday  = $request->has('saturday') ? $request->saturday : $teacher->saturday;
            $teacher->sunday    = $request->has('sunday') ? $request->sunday : $teacher->sunday;

            if ($request->hasFile('image')) {
                Storage::delete($teacher->image);
                $imageFile = $request->file('image');
                $imagePath = $imageFile->store('public/teachers');
                $teacher->image = $imagePath;
            }

            $teacher->save();

            return response()->json([
                'status'    => true,
                'message'   => "老師資料修改成功",
                'name'      => $request->name,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => false,
                'message'   => '發生錯誤',
                'error'     => $th->getMessage(),
                // 'trace'     => $th->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
    
            Storage::delete($teacher->image);

            $teacher->delete();
    
            return response()->json([
                'status'  => true,
                'message' => '刪除成功',
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'status'  => false,
                'message' => '發生錯誤',
                'error'   => $th->getMessage(),
            ], 500);

        }
    }
}
