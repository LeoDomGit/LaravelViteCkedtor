<?php

namespace Leo\Compains\Controllers;

use Leo\Campains\Models\Campains;
use Illuminate\Http\Request;

class CampainsController extends Controller
{
    public function index()
    {
        $campains =Campains::all();
        return response()->json($campains);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'start' => 'nullable|date',
            'end' => 'required|date',
        ]);

        if (is_null($validatedData['start'])) {
            $validatedData['start'] = now();
        }

        $campain = Campains::create($validatedData);
        return response()->json($campain, 201);
    }

    public function show($id)
    {
        $campain = Campains::findOrFail($id);
        return response()->json($campain);
    }

    public function update(Request $request, $id)
    {
        $campain = Campains::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'start' => 'nullable|date',
            'end' => 'required|date',
        ]);

        if (is_null($validatedData['start'])) {
            $validatedData['start'] = now();
        }

        $campain->update($validatedData);
        return response()->json($campain);
    }

    public function destroy($id)
    {
        $campain = Campains::findOrFail($id);
        $campain->delete();
        return response()->json(['message' => 'Campain deleted successfully']);
    }

    public function getNearestUpcomingCampaign()
    {
        $currentDateTime = now();

        $campain = Campains::where(function ($query) use ($currentDateTime) {
            $query->where('start', '>', $currentDateTime)
                  ->orWhereNull('start');
        })
        ->where('end', '>', $currentDateTime)
        ->orderBy('start', 'asc')
        ->first();

        if ($campain) {
            return response()->json($campain);
        } else {
            return response()->json(['message' => 'No upcoming campaigns found'], 200);
        }
    }
}
