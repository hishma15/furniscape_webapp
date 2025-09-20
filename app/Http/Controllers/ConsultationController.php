<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Consultation;
use App\Http\Resources\ConsultationResource;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Fetch consultation with customer and admin 
        $consultations = Consultation::with(['customer', 'admin'])->paginate(10);
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
            'admin_id' => 'required|exists:users,_id',
            'customer_id' => 'required|exists:users,_id',
        ]);

        // Set the status to 'pending' by default for new consultations
        $validated['status'] = 'pending';


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
        // Fetch the consultation
        $consultation = Consultation::findOrFail($id);

        // Validate the status update [update status can only be done after creating a consultation]
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled', // allowed statuses
        ]);

        // Check if the consultation is already confirmed or completed
        if (in_array($consultation->status, ['confirmed', 'completed'])) {
            // If the consultation is already confirmed or completed, prevent changing status to 'pending'
            if ($validated['status'] === 'pending') {
                return response()->json(['error' => 'Cannot revert status to pending after confirmation/completion.'], 400);
            }
        }

        // Check if the user is allowed to change the status
        $status = $validated['status'];

        // Check for who is making the update and validate permissions
        if ($status === 'confirmed' || $status === 'completed') {
            // Only admin can confirm or complete the consultation
            if (!auth()->user()->isAdmin()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        if ($status === 'cancelled') {
            // Either admin or customer can cancel the consultation
            if (auth()->user()->id !== $consultation->admin_id && auth()->user()->id !== $consultation->customer_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        // Update the status of the consultation
        $consultation->update($validated);

        // Return the updated consultation resource
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
