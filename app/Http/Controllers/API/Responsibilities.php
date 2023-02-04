<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Responsibility;
use App\Helpers\ResponseFormatter;

class Responsibilities extends Controller
{
    public function fecth(Request $request)
    {
        $responsibilities = Responsibility::all();
        return ResponseFormatter::success($responsibilities, 'Responsibilities found');
    }
}
