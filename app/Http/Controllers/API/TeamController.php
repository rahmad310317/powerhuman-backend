<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Models\Team;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;


class TeamController extends Controller
{
    public function create(CreateTeamRequest $request)
    {
        try {
            // Upload icon
            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }

            // Create company
            $team = Team::create([
                'name' => $request->name,
                'icon' => $path,
                'company_id' => $request->company_id
            ]);

            if (!$team) {
                throw new Exception('Team not created');
            }

            // Attach company to user
            $user = User::find(Auth::id());
            $user->team()->attach($team->id);

            // Load users at company
            $team->load('users');

            return ResponseFormatter::success($team, 'Team created');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function update(UpdateTeamRequest $request, $id)
    {
        try {
            // Get company
            $team = Team::find($id);

            // Check if company exists
            if (!$team) {
                throw new Exception('Team not found');
            }

            // Upload logo
            if ($request->hasFile('icon')) {
                $path = $request->file('icon')->store('public/icons');
            }

            // Update company
            $team->update([
                'name' => $request->name,
                'icon' => isset($path) ? $path : $team->icon,
            ]);

            return ResponseFormatter::success($team, 'Team updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function fecth(Request $request)
    {
    }
}
