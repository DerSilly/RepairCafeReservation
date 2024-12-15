<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Repairs;
use Illuminate\Http\Request;
use App\Http\Resources\RepairResource;
use App\Traits\ApiResponses;

class RepairsController extends Controller
{

    public function __construct(  ) {
    }

    public function index(Request $request)
    {
        ini_set('memory_limit', '2048M');
        $repairs = Repairs::all()->where('country', 'DE');
        return RepairResource::collection($repairs);
    }
}
