<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;

class TeamController extends Controller
{
    public function fetch(CreateTeamRequest $request)
    {
        // Get request data
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);
    }
}
