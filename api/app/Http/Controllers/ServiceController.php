<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'business_id' => 'required|exists:businesses,id',
        ]);

        $service = Service::create($request->all());

        return response()->json($service, 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'business_id' => 'sometimes|required|exists:businesses,id',
        ]);

        $service->update($request->all());

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, 204);
    }
    public function getByBusiness($id)
    {
        return response()->json(
            Service::where('business_id', $id)->get()
        );
    }

}

    