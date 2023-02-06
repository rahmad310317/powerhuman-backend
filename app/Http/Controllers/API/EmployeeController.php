<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employes;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateEmployeesRequest;
use App\Http\Requests\UpdateEmployeesRequest;
use Exception;

class EmployeeController extends Controller
{
    public function fetch(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Employees not found');
        }
    }

    public function create(CreateEmployeesRequest $request)
    {
        try {
            $employee = Employes::create([
                'name' => $request->name,
                'age' => $request->age,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $request->role_id,
                'team_id' => $request->team_id,
            ]);

            if (!$employee) {
                throw new Exception('Employee not created');
            }
            return ResponseFormatter::success($employee, 'Employee created');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Employee not created');
        }
    }
    public function update(UpdateEmployeesRequest $request, $id)
    {
        try {
            $employee = Employes::find($id);
            if (!$employee) {
                throw new Exception('Employee not found');
            }
            $employee->update([
                'name' => $request->name,
                'age' => $request->age,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $request->role_id,
                'team_id' => $request->team_id,
            ]);
            return ResponseFormatter::success($employee, 'Employee updated');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Employee not updated');
        }
    }
    public function destroy($id)
    {
        try {
            $employee = Employes::find($id);
            if (!$employee) {
                throw new Exception('Employee not found');
            }
            $employee->delete();
            return ResponseFormatter::success($employee, 'Employee deleted');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Employee not deleted');
        }
    }
}
