<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;

class ApiCompaniesController extends Controller
{
    public function getCompaniesTabular() {
        $company = Company::orderBy('id', 'desc')->get();
        return response()->json($company);
    }
}
