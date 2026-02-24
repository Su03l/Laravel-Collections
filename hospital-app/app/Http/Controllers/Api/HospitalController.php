<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\HospitalResource;
use App\Models\Clinic;
use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    // show all hospitals
    public function index()
    {
        $hospitals = Hospital::all();
        return $this->success(HospitalResource::collection($hospitals), 'قائمة المستشفيات');
    }

    // show all clinics
    public function getClinics()
    {
        $clinics = Clinic::all();
        return $this->success(ClinicResource::collection($clinics), 'قائمة التخصصات');
    }
}
