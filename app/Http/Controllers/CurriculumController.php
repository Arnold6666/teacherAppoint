<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
    public function show(Curriculum $curriculum)
    {
        //
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
    public function update(Request $request, Curriculum $curriculum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {
        //
    }
}
