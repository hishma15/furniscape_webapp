<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Consultation;
use App\Models\User;
use App\Http\Resources\ConsultationResource;

class ConsultationController extends Controller
{
    public function createForm()
    {
        $admin = User::where('role', 'admin')->first();
        return view('customer.consultationForm', compact('admin'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Fetch consultation 
        $consultations = Consultation::paginate(10);
        return ConsultationResource::collection($consultations); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate incoming request
        $validated = $request->validate([
            'prefered_date' => 'required|date',
            'prefered_time' => 'required|date_format:H:i',
            'mode' => 'required|string',
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Securerd logged in user
        $validated['customer_id'] = auth()->id();

        // Set the status to 'pending' by default for new consultations
        $validated['status'] = 'pending';

        // Assign any admin for now (or logic to assign a specific one)
        $admin = User::where('role', 'admin')->first();
        $validated['admin_id'] = $admin->id ?? null;

        // Create the consultation record
        $consultation = Consultation::create($validated);

        // Return the created consultation resource
        return new ConsultationResource($consultation);

    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find consultation by ID and include related customer and admin data
        $consultation = Consultation::with(['customer', 'admin'])->findOrFail($id);
        return new ConsultationResource($consultation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consultation = Consultation::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $consultation->update($validated);

        return new ConsultationResource($consultation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find consultation by ID
        $consultation = Consultation::findOrFail($id);

        // Check if the consultation is confirmed or completed
        if (in_array($consultation->status, ['confirmed', 'completed'])) {
            return response()->json(['error' => 'Cannot delete confirmed or completed consultations.'], 400);
        }

        // Delete the consultation record
        $consultation->delete();

        // Return success message
        return response()->json(['message' => 'Consultation deleted successfully.'], 200);
    }

    public function statusSummary() {
        $statusCounts = Consultation::raw(function($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$status',
                        'count' => ['$sum' => 1]
                    ]
                ],
                [
                    '$sort' => ['count' => -1]
                ]
            ]);
        });
        return response()->json($statusCounts);
    }

}
