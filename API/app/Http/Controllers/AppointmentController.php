<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\RepairDetail;
use App\Models\Device;
use App\Models\Location;
use App\Models\User;

use App\Http\Resources\AppointmentResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\DeviceResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\RepairDetailResource;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Psy\SystemEnv;

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
        if(true || Gate::allows('viewAny', Appointment::class))
        {
            $appointments = AppointmentResource::collection(Appointment::all());
        }
        else
        {
            $appointments = AppointmentResource::collection($request->user()->appointments()->get());
        }


        return $this->successResponse($appointments);
    }

    // Retrieve and return a single appointment by ID
    public function show($id)
    {
        $appointment = new AppointmentResource(Appointment::findOrFail($id));
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
        if(!Gate::allows('create', Appointment::class))
        {
            return $this->errorResponse('Unauthorized', 403);
        }

        $validatedData = $request->validate([
            'startTime' => 'required|date|before:endTime',
            'endTime' => 'required|date|after:startTime',
            'note' => 'nullable|string',
            'guest.name' => 'required|unique:users,name',
            'location.id' => 'required|exists:locations,id',
            'device.kindProduct' => 'required|string',
            'device.category' => 'nullable|string',
            'device.fault' => 'required|string|min:10',
            'device.brand' => 'nullable|string',
            'device.productBuildYear' => 'nullable|numeric|between:1900,' . date('Y'),
            'device.model' => 'nullable|string',
        ]);

        $appointmentData = array_merge(
            Arr::except($validatedData, ['startTime', 'endTime', 'productBuildYear', 'kindProduct']),
            ['start_time' => $validatedData['startTime'],
             'end_time' => $validatedData['endTime'],
             'product_build_year' => $validatedData['device']['productBuildYear'],
             'kind_product' => $validatedData['device']['kindProduct'],
             'location_id' => $validatedData['location']['id'],
            ]);
        $appointment = DB::transaction(function () use ($appointmentData) {
            $guest = User::firstOrCreate([
                'name' => $appointmentData['guest']['name'],
                'email' => $appointmentData['guest']['name'] . '@' . $_SERVER['HTTP_HOST'],
                'password' => bcrypt('password'),
                'roles' => [new Role(['name' => 'Guest'])],
            ]);
            $appointment = $guest->appointments()->create($appointmentData);

            return $appointment;
        });
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

        if(!Gate::allows('delete', $appointment))
        {
            return $this->errorResponse('Unauthorized', 403);
        }

        $appointment->devices()->detach();
        $appointment->delete();

        return $this->successResponse(null, 'Appointment deleted successfully');
    }
}
