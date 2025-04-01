<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        return response()->json(Business::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'owner_id' => 'nullable|exists:users,id',
            'address' => 'nullable|string|max:255',
        ]);

        $business = Business::create($validated);

        return response()->json($business, 201);
    }

    public function show(Business $business)
    {
        return response()->json($business);
    }

    public function update(Request $request, Business $business)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'owner_id' => 'nullable|exists:users,id',
            'address' => 'nullable|string|max:255',
        ]);

        $business->update($validated);

        return response()->json($business);
    }

    public function destroy(Business $business)
    {
        $business->delete();

        return response()->json(null, 204);
    }
}
