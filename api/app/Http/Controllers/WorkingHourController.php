<?php

namespace App\Http\Controllers;

use App\Models\WorkingHour;
use Illuminate\Http\Request;

class WorkingHourController extends Controller
{
    public function index()
    {
        return response()->json(WorkingHour::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'business_id' => 'required|exists:businesses,id',
        ]);

        $workingHour = WorkingHour::create($request->all());

        return response()->json($workingHour, 201);
    }

    public function show(WorkingHour $workingHour)
    {
        return response()->json($workingHour);
    }

    public function update(Request $request, WorkingHour $workingHour)
    {
        $request->validate([
            'day_of_week' => 'sometimes|required|integer|min:0|max:6',
            'start_time' => 'sometimes|required|date_format:H:i:s',
            'end_time' => 'sometimes|required|date_format:H:i:s',
            'business_id' => 'sometimes|required|exists:businesses,id',
        ]);

        $workingHour->update($request->all());

        return response()->json($workingHour);
    }

    public function destroy(WorkingHour $workingHour)
    {
        $workingHour->delete();

        return response()->json(null, 204);
    }
}