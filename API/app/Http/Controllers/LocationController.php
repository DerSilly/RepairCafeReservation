<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Http\Resources\LocationResource;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class LocationController extends Controller implements HasMiddleware
{
    use ApiResponses;

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }

    public function index()
    {
        return LocationResource::collection(Location::all());
    }

    public function show($id)
    {
        $location = Location::findOrFail($id);
        return new LocationResource($location);
    }

    public function store(Request $request)
    {
        $location = Location::create($request->all());
        return new LocationResource($location);
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->update($request->all());
        return new LocationResource($location);
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return response()->json(null, 204);
    }
}
