<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Auth;


class CompanyController extends Controller
{
    // Fuction All Company 
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');

        if ($id) {
            $company = Company::with(['users'])->find($id);
            if ($company) {
                return ResponseFormatter::success(
                    $company,
                    'Data company berhasil diambil'
                );
            }
            return ResponseFormatter::error(
                null,
                'Data company tidak ada',
                404
            );
        }
        $companies = Company::with(['users']);

        if ($name) {
            $companies->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $companies->paginate($limit),
            'Data list company berhasil diambil'
        );
    }

    // Function Create Company
    public function create(CreateCompanyRequest $request)
    {

        try {
            // Upload logo
            if ($request->hasfile('logo')) {
                $path = $request->file('logo')->store('public/storage');
            }
            // Create company
            $company = Company::create([
                'name' => $request->name,
                'logo' => $path,
            ]);

            if (!$company) {
                return ResponseFormatter::error(
                    null,
                    'Data company gagal ditambahkan',
                    500
                );
            }

            // Attach user to company
            $user = Auth::user();
            $user->companies()->attach($company->id);

            // load user and company
            $company->load('users');

            // Return response
            return ResponseFormatter::success(
                $company,
                'Data company berhasil ditambahkan'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Authentication Failed',
                500
            );
        }
    }

    public function update(UpdateCompanyRequest $request, $id)
    {


        try {
            $company = Company::find($id);

            if (!$company) {
                return ResponseFormatter::error(
                    null,
                    'Data company tidak ada',
                    404
                );
            }

            if ($request->hasfile('logo')) {
                $path = $request->file('logo')->store('public/storage');
            }

            $company->update([
                'name' => $request->name,
                'logo' => $path,
            ]);

            return ResponseFormatter::success(
                $company,
                'Data company berhasil diubah'
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
