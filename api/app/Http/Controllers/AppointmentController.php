<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
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
        Log::info('Autenticación detectada', [
            'check' => auth()->check(),
            'user_id' => auth()->id(),
            'token' => request()->bearerToken()
        ]);

        try {
            // Validación
            $validated = $request->validate([
                'service_id'   => 'required|exists:services,id',
                'business_id'  => 'required|exists:businesses,id',
                'date'         => 'required|date',
                'time'         => 'required|date_format:H:i:s',
                'name'         => 'required|string',
                'phone'        => 'required|string',
                'customer_id'  => 'required|exists:users,id',
            ]);
    
            // Log del payload recibido
            Log::debug('Payload recibido para crear cita:', $validated);
    
            // Creación de la cita
            $appointment = Appointment::create([
                'service_id'   => $validated['service_id'],
                'business_id'  => $validated['business_id'],
                'date'         => $validated['date'],
                'time'         => $validated['time'],
                'name'         => $validated['name'],
                'phone'        => $validated['phone'],
                'status'       => 'pending',
                'customer_id'  => $validated['customer_id'],
            ]);
    
            Log::info('Cita creada correctamente', ['appointment_id' => $appointment->id]);
    
            return response()->json($appointment, 201);
    
        } catch (\Throwable $e) {
            Log::error('Error al crear cita: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
    
            return response()->json([
                'error' => 'Error interno al crear la cita'
            ], 500);
        }
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
    public function getAvailableHours(Request $request, $businessId)
    {
        $date = $request->query('date');
        \Log::info("Solicitando horarios disponibles", ['business_id' => $businessId, 'date' => $date]);
        if (!$date) {
            return response()->json(['error' => 'Fecha requerida'], 400);
        }

        $dayOfWeek = date('N', strtotime($date)); // 1 (Mon) - 7 (Sun)

        $workingHour = \App\Models\WorkingHour::where('business_id', $businessId)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$workingHour) {
            \Log::info("No se encontró horario laboral para el negocio {$businessId} en el día {$dayOfWeek}");
            return response()->json(['error' => 'El negocio no tiene horario para este día'], 404);
        } else {
            \Log::info("Horario encontrado", ['start_time' => $workingHour->start_time, 'end_time' => $workingHour->end_time]);
        }

        $start = strtotime($workingHour->start_time);
        $end = strtotime($workingHour->end_time);
        $interval = 30 * 60; // 30 minutos
        $allHours = [];

        for ($time = $start; $time + $interval <= $end; $time += $interval) {
            $allHours[] = date('H:i', $time);
        }

        if (empty($allHours)) {
            \Log::info("No se generaron horarios disponibles para el negocio {$businessId} el día {$date} ({$dayOfWeek}) entre {$workingHour->start_time} y {$workingHour->end_time}");
        }

        $taken = Appointment::where('business_id', $businessId)
            ->where('date', $date)
            ->pluck('time')
            ->map(function ($t) {
                return substr($t, 0, 5); // trim to HH:MM
            })
            ->toArray();

        $available = array_values(array_diff($allHours, $taken));

        \Log::info("Horarios generados", ['total' => count($allHours), 'disponibles' => $available]);

        return response()->json($available);
    }
}