<?php
namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read all services');
        $services= Service::all();
        return view('pages.service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-service');
       return view('pages.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-service');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ],[
            'name.required' => 'This field is required',
            'image.required' => 'This field is required',
            'description.required' => 'This field is required',
            'price.required' => 'This field is required',
            'duration.required' => 'This field is required',
        ]);
        $service= new Service();

        // handel image 
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $service->image = '/images/'.$filename;       
        }
       $service->name=$request->name;
       $service->description=$request->description;
       $service->price=$request->price;
       $service->duration=$request->duration;
      
       $service->save();
        
        return redirect()->route('serviceweb.index')->with('success', 'Service created successfully');
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
    public function edit(Service $serviceweb)
    {
        Gate::authorize('update-service');
        return view('pages.service.edit',compact('serviceweb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $serviceweb)
    {
        Gate::authorize('update-service');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ],[
            'name.required' => 'This field is required',
            'image.required' => 'This field is required',
            'description.required' => 'This field is required',
            'price.required' => 'This field is required',
            'duration.required' => 'This field is required',
        ]);

        // handel image 
        if ($request->hasFile('image')) {
        // remove old image
            if ($serviceweb->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($serviceweb->getRawOriginal('image')))) {
                unlink(public_path($serviceweb->getRawOriginal('image')));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $serviceweb->image = '/images/'.$filename;       
        }
        $serviceweb->name=$request->name;
        $serviceweb->description=$request->description;
        $serviceweb->price=$request->price;
        $serviceweb->duration=$request->duration;
        
        $serviceweb->save();
        return redirect()->route('serviceweb.index')->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $serviceweb)
    {
        Gate::authorize('delete-service');
        $serviceweb->delete();
        return redirect()->route('serviceweb.index')->with('error', 'Service Deleted');
    }
}
