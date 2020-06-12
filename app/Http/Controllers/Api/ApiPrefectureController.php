<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Prefecture;

class ApiPrefectureController extends Controller
{
    public function getPrefectureList(){
        $prefecture = Prefecture::all();

        return response()->json($prefecture);
    }
}
