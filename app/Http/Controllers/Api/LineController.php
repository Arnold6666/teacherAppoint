<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LineController extends Controller
{
    //
    public function index(Request $request){
        error_log(json_encode('1'));
        return response('ok','200');
    }
}
