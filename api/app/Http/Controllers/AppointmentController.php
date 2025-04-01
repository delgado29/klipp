<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'employee_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'business_id' => 'required|exists:businesses,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'customer_id' => 'sometimes|required|exists:users,id',
            'employee_id' => 'sometimes|required|exists:users,id',
            'service_id' => 'sometimes|required|exists:services,id',
            'business_id' => 'sometimes|required|exists:businesses,id',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|date_format:H:i:s',
            'status' => 'sometimes|required|string|in:pending,confirmed,cancelled,completed',
        ]);

        $appointment->update($request->all());

        return response()->json($appointment);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(null, 204);
    }
}