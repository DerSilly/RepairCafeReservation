<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\RepairDetail;
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
            'location_id' => 'required|exists:locations,id',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'note' => 'nullable|string',
            //Device
            'kind_product' => 'string',
            'category' => 'nullable|string',
            'brand' => 'nullable|string',
            'product_build_year' => 'nullable|numeric|between:1900,' . date('Y'),
            'model' => 'nullable|string',
            'cause_of_fault' => 'string|min:10',
            'note' => 'nullable|string',
        ]);

        $appointment = $request->user()->appointment()->create($validatedData);
        $device = $appointment->devices()->create($validatedData);
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
            'staff_id' => 'required|exists:users,id',
            'note' => 'sometimes|string',
        ]);

        $validatedData['staff_id'] = $request->user()->id;
        $appointment->update($validatedData);
        $appointment = Appointment::find($id);

        return $this->successResponse($appointment, 'Appointment updated successfully', 200);
    }

    // Update an existing appointment by ID
    public function postpone(Request $request, $id)
    {
        $oldAppointment = Appointment::find($id);
        if (!$oldAppointment) {
            return $this->errorResponse('Appointment not found', 404);
        }

        if(!Gate::allows('postpone', $oldAppointment))
        {
            return $this->errorResponse('Unauthorized', 403);
        }

        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'note' => 'required|string'
        ]);

        $validatedData['staff_id'] = $request->user()->id;
        $validatedData['guest_id'] = $oldAppointment->guest_id;
        $appointment =  Appointment::create($validatedData);
        $appointment->devices()->attach($oldAppointment->devices[0]);
        return $this->successResponse($appointment, 'Appointment created successfully', 201);
    }

    // Delete an appointment by ID
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return $this->errorResponse('Appointment not found', 404);
        }

        foreach ($appointment->devices() as $device) {
            $device?->repairDetail()?->delete();
        }
        $appointment->devices()->delete();
        $appointment->delete();

        return $this->successResponse(null, 'Appointment deleted successfully');
    }
}
