<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminClinicController extends Controller
{
    // store clinic data from admin
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:clinics,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $clinic = Clinic::create($request->all());
        return $this->success($clinic, 'تمت إضافة العيادة بنجاح', 201);
    }
}
