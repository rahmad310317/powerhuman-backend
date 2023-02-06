<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employes;
use App\Helpers\ResponseFormatter;

class EmployeeController extends Controller
{
    public function fetch(Request $request)
    {
        // Get Employees 
        $id = $request->input('id');
        $name = $request->input('name');
        $age = $request->input('age');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $role_id = $request->input('role_id');
        $team_id = $request->input('team_id');
        $limit = $request->input('limit', 10);

        $employeeQuery = Employes::query();

        // Get single data
        if ($id) {
            $employee = $employeeQuery->with(['team_id', 'role_id'])->find($id);
            if ($employee) {
                return ResponseFormatter::success($employee, 'Employee found');
            }
        }
        // Get multiple data 
        $employee = $employeeQuery;

        if ($name) {
            $employee->where('name', 'like', '%' . $name . '%');
        }
        if ($age) {
            $employee->where('age', 'like', '%' . $age . '%');
        }
        if ($email) {
            $employee->where('email', $email);
        }
        if ($phone) {
            $employee->where('phone', 'like', '%' . $phone . '%');
        }
        if ($role_id) {
            $employee->where('role_id', 'like', '%' . $role_id . '%');
        }
        if ($team_id) {
            $employee->where('team_id', 'like', '%' . $team_id . '%');
        }
        return ResponseFormatter::success(
            $employee->paginate($limit),
            'Employees found'
        );
    }
}
