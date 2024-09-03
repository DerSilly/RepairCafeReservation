<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller implements HasMiddleware
{
    use ApiResponses;

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }

    // Retrieve and return a list of appointments
    public function index(Request $request)
    {
        if(Gate::allows('viewAny', Appointment::class))
        {
            $appointments = Appointment::all();
        }
        else
        {
            $appointments = $request->user()->appointment()->get();
        }

        return $this->successResponse($appointments);
    }

    // Retrieve and return a single appointment by ID
    public function show($id)
    {
        $appointment = Appointment::find($id);
        if(!Gate::allows('view', $appointment))
        {
            return $this->errorResponse('Unauthorized', 403);
        }

        if (!$appointment) {
            return $this->errorResponse('Appointment not found', 404);
        }

        return $this->successResponse($appointment);
    }

    // Create a new appointment
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:devices,id',
            'device_id' => 'required|exists:devices,id',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'note' => 'sometimes|string',
        ]);

        $appointment = $request->user()->appointment()->create($validatedData);
Device::
        return $this->successResponse($appointment, 'Appointment created successfully', 201);
    }

    // Update an existing appointment by ID
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if(!Gate::allows('update', $appointment))
        {
            return $this->errorResponse('Unauthorized', 403);
        }

        if (!$appointment) {
            return $this->errorResponse('Appointment not found', 404);
        }

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:devices,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'note' => 'sometimes|string',
        ]);

        $appointment->update($validatedData);
        $appointment = Appointment::find($id);

        return $this->successResponse($appointment, 'Appointment created successfully', 201);
   }

    // Delete an appointment by ID
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->errorResponse('Appointment not found', 404);
        }

        $appointment->delete();

        return $this->successResponse(null, 'Appointment deleted successfully');
    }
}
