<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Curriculum;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Illuminate\Support\Str;


require 'C:\Users\Arnoid\Desktop\teacherappoint\vendor\autoload.php';

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
        $validateUser = validator::make($request->all(), [
            'teacher'      => 'required',
            'datetime'  => 'required',
        ]);

        //失敗後回傳並終止
        if ($validateUser->fails()) {

            $errors = $validateUser->errors()->all();
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

        
        $user = Auth::guard('api')->user();
        $student = $user->id;

        $teacher = Teacher::where('id', $request->teacher)->first();

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        try {

            foreach ($request->datetime as $datetime) {

                $uuid_temp = str_replace("-", "",substr(Str::uuid()->toString(), 0,18));

                $curriculum     = new Curriculum;
                $date = Carbon::parse($datetime);
                $curriculum->uuid           = $uuid_temp;
                $curriculum->teacher_id     = $request->teacher;
                $curriculum->student_id     = $student;
                $curriculum->date           = $date->format('Y-m-d');
                $curriculum->time           = $date->format('H:i:s');
                $curriculum->price          = $teacher->price;
                $curriculum->created_at     = $dateTimeStr;
                $curriculum->updated_at     = $dateTimeStr;
                $curriculum->save();
            }

            return response()->json([
                'status'    => true,
                'message'   => "課程申請成功"
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'status'    => false,
                'message'   => "課程申請失敗",
                // 'error'     => $th->getMessage(),
                // 'trace'     => $th->getTraceAsString()
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $user = Auth::guard('api')->user();

        $curriculums = Curriculum::with('teacher')->with('state')
            ->where('student_id', $user->id)
            ->orderBy('date')
            ->get();

        $formattedMessages = $curriculums->map(function ($message) {
            return [
                'id' => $message->id,
                'teacher' => $message->teacher->name,
                'date' => $message->date,
                'time' => $message->time,
                'price' => $message->price,
                'comment' => $message->comment,
                'stars' => $message->stars,
            ];
        });

        return response()->json([
            'status'    => true,
            'message'   => $formattedMessages
        ], 200);
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
        if ($curriculum->state_id != 3) {
            return response()->json([
                'status'    => false,
                'message'   => "請用正確的方式，進行評論課程",
            ], 404);
        }

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

                return response()->json([
                    'status'    => false,
                    'message'   => $message,
                ], 404);
            }

            $curriculum->stars = $request->stars;
            $curriculum->comment = $request->comment;
            $curriculum->updated_at = $dateTimeStr;
            $curriculum->state_id = 4;
            $curriculum->save();

            return response()->json([
                'status'    => true,
                'message'   => '評價已完成'
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'status'    => false,
                'message'   => "評價失敗",
                // 'error'     => $th->getMessage(),
                // 'trace'     => $th->getTraceAsString()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $curriculum = Curriculum::findOrFail($id);
            $curriculum->state_id = 6;
            $curriculum->updated_at = Carbon::now()->toDateTimeString();
            $curriculum->save();

            return response()->json([
                'status'    => true,
                'message'   => '課程已取消'
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'status'    => false,
                'message'   => "發生錯誤，請重新嘗試",
                // 'error'     => $th->getMessage(),
                // 'trace'     => $th->getTraceAsString()
            ], 404);
        }
    }

    public function refund($id)
    {
        $curriculum = Curriculum::findOrFail($id);

        if ($curriculum->state !== 2) {
            return response()->json([
                'status'    => false,
                'message'   => "已付款未上課的課程，才能退款喔",
            ], 404);
        }

        try {
            $curriculum->state_id = 7;
            $curriculum->updated_at = Carbon::now()->toDateTimeString();
            $curriculum->save();

            return response()->json([
                'status'    => true,
                'message'   => '已進入退款處理程序，退款成功，將會通知您喔',
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => false,
                'message'   => "發生錯誤，請重新嘗試",
                // 'error'     => $th->getMessage(),
                // 'trace'     => $th->getTraceAsString()
            ], 404);
        }
    }

    public function unPay()
    {

        $curriculums = Curriculum::with('teacher')->with('state')
            ->where('student_id', 1)->where('state_id', 1)
            ->orderBy('date')
            ->get();

        return view('unpay', compact('curriculums'));
    }


    public function Pay(Request $request)
    {

        try {
            $curriculum = Curriculum::where('uuid',$request->uuid)->first();
            $tradeId = $curriculum->uuid;
            $amount = $curriculum->price;

            $factory = new Factory([
                'hashKey' => '5294y06JbISpM5x9',
                'hashIv' => 'v77hoKGq4kWxNNIS',
            ]);
            $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');
            // $randomNumber = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);

            $input = [
                'MerchantID' => '2000132',
                'MerchantTradeNo' => $tradeId ,
                'MerchantTradeDate' => date('Y/m/d H:i:s'),
                'PaymentType' => 'aio',
                'TotalAmount' => $amount,
                'TradeDesc' => UrlService::ecpayUrlEncode('交易描述範例'),
                'ItemName' => $amount . ' TWD x 1',
                'ChoosePayment' => 'Credit',
                'EncryptType' => 1,

                // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
                'ReturnURL' => 'https://e51e-106-105-92-36.jp.ngrok.io/api/curriculum/callback',
            ];

            $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

            echo $autoSubmitFormService->generate($input, $action);

            return view('unpay', compact('curriculums'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function callback(Request $request)
    {

        $curriculum = Curriculum::findorfail(substr($request->MerchantTradeNo, 0, -6));
        $curriculum->state_id = 2;
        $curriculum->save;

        return view('unpay');
    }
}
