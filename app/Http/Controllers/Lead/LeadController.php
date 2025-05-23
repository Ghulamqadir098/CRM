<?php
namespace App\Http\Controllers\Lead;


use App\Models\Lead;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with('user')->get();
        
      return view('pages.lead.index',compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

         $agents= User::role('agent')->get();
         if ($agents->isEmpty()) {
            return back()->with('error', 'Agents not found');
         }  
        return view('pages.lead.create',compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'source' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:255',
        ],[
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'source.required' => 'This field is required',
            'user_id.required' => 'This field is required',
            'status.required' => 'This field is required',
        ]);
      Lead::create($request->all());
      return redirect()->route('leadweb.index')->with('success', 'Lead created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $leadweb)
    { 

       if(Gate::allows('read-all-leads')){
        $agents= User::role('agent')->get();
        if ($agents->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Agents not found',
                'data' => []
            ], 404);
        }  
          $lead=$leadweb;
        return view('pages.lead.edit',compact('lead','agents'));
       }
       elseif(Gate::allows('update-lead', $leadweb)){
        $agents= User::role('agent')->get();
        if ($agents->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Agents not found',
                'data' => []
            ], 404);
        }  
          $lead=$leadweb;
        return view('pages.lead.edit',compact('lead','agents'));
       }
       else{
        abort(403, 'Unauthorized action.');
       }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $leadweb)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'source' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string|max:255',
        ],[
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'source.required' => 'This field is required',
            'user_id.required' => 'This field is required',
            'status.required' => 'This field is required',
        ]);
       if(Gate::allows('read-all-leads')){
        $leadweb->update($request->all());
        return redirect()->route('leadweb.index')->with('success', 'Lead updated successfully');
       }
       elseif(Gate::allows('update-lead', $leadweb)){
        $leadweb->update($request->all());
        return redirect()->route('leadweb.index')->with('success', 'Lead updated successfully');
       }
       else{
        abort(403, 'Unauthorized action.');
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $leadweb)
    {
       if(Gate::allows('read-all-leads')){
        $leadweb->delete();
        return redirect()->route('leadweb.index')->with('error', 'Lead Deleted');
       }
       elseif(Gate::allows('delete-lead', $leadweb)){
        $leadweb->delete();
        return redirect()->route('leadweb.index')->with('error', 'Lead Deleted');
       }
       else{
        abort(403, 'Unauthorized action.');
       }
    }
}
