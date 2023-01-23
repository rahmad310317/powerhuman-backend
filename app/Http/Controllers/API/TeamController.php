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
                'team_id' => $request->team_id
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
                'team_id' => $request->team_id
            ]);

            return ResponseFormatter::success($team, 'Team updated');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
    public function fetch(Request $request)
    {
        // Get request data
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        // Get company data
        $teamQuery = Team::query();

        // Get single data
        if ($id) {
            $team = $teamQuery->find($id);

            if ($team) {
                return ResponseFormatter::success($team, 'Team found');
            }
            return ResponseFormatter::error('Team not found', 404);
        }

        // Get multiple data
        $teams = $teamQuery->where('company_id', $request->company->id);

        if ($name) {
            $teams->where('name', 'like', '%' . $name . '%');
        }
        // Return response
        return ResponseFormatter::success(
            $teams->paginate($limit),
            'Companies found'
        );
    }
    public function destroy($id)
    {
        try {
            // Get company
            $team = Team::find($id);

            // Check if company exists
            if (!$team) {
                throw new Exception('Team not found');
            }

            // Delete company
            $team->delete();

            return ResponseFormatter::success($team, 'Team deleted');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
