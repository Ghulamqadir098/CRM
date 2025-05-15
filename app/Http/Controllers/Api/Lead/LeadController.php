<?php
namespace App\Http\Controllers\Api\Lead;


use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadUpdateRequest;
// use Illuminate\Auth\Access\Gate;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read-all-leads');
        $leads = Lead::with('user')->get();
       if ($leads->isEmpty()) {
           return response()->json([
               'success' => false,
               'message' => 'Leads not found',
               'data' => []
           ], 404);
       }
       return response()->json([
        'success' => true,
        'message' => 'Leads fetched successfully',
        'data' => $leads
    ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadStoreRequest $request)
    {  Gate::authorize('create-lead');
       $agent = $request->user();
       $lead = $agent->leads()->create($request->all());
       return response()->json([
        'success' => true,
        'message' => 'Lead created successfully',
         'data' => $lead,
       ],201); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        Gate::authorize('read-lead');
        return response()->json([
            'success' => true,
            'message' => 'Lead fetched successfully',
            'data' => $lead
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadUpdateRequest $request, Lead $lead)
    {
        Gate::authorize('update-lead');
        $lead->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Lead updated successfully',
            'data' => $lead
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        Gate::authorize('delete-lead');
        $lead->delete();
        return response()->json([
            'success' => true,
            'message' => 'Lead deleted successfully',
        ],200);
    }
}
