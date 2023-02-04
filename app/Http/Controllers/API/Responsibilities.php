<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Responsibility;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateResponsibilitiesRequest;
use Exception;

class Responsibilities extends Controller
{
    public function fecth(Request $request)
    {

        try {
            // Get Responsiblities
            $id = $request->input('id');
            $name = $request->input('name');
            $limit = $request->input('limit', 10);

            $responsibilityQuery = Responsibility::query();

            // Get single data
            if ($id) {
                $responsibility = $responsibilityQuery->find($id);

                if ($responsibility) {
                    return ResponseFormatter::success($responsibility, 'Responsibility found');
                }
            }
            // Get multiple data
            $responsibilities = $responsibilityQuery->where('role_id', $request->role_id);

            if ($name) {
                $responsibilities->where('name', 'like', '%' . $name . '%');
            }

            return ResponseFormatter::success(
                $responsibilities->paginate($limit),
                'Responsibilities found'
            );
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 'Responsibilities not found');
        }
    }

    public function create(CreateResponsibilitiesRequest $request)
    {
        try {
            // Create responsibility
            $responsibility = Responsibility::create([
                'name' => $request->name,
                'role_id' => $request->role_id,
            ]);

            if (!$responsibility) {
                throw new Exception('Responsibility not created');
            }

            return ResponseFormatter::success($responsibility, 'Responsibility created');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 'Create responsibility failed');
        }
    }
    public function destroy($id)
    {
        try {
            //  Get responsibility
            $responsibility = Responsibility::find($id);
            // Check if responsibility exists
            if (!$responsibility) {
                throw new Exception('Responsibility not found');
            }
            // Delete responsibility
            $responsibility->delete();
            return ResponseFormatter::success($responsibility, 'Responsibility deleted');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 'Delete responsibility failed');
        }
    }
}
