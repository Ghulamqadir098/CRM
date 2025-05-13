<?php
namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services=Service::all();
        if ($services->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Services not found',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $services,
            'message' => 'Services fetched successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        $service= new Service();
        $service->name=$request->name;
        $service->description=$request->description;
        $service->price=$request->price;
        $service->duration=$request->duration;
        // handel image 
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $service->image = '/images/'.$filename;
        }
        $service->save();
        
        return response()->json([
            'success' => true,
            'data' => $service,
            'message' => 'Service created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service,
            'message' => 'Service fetched successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, Service $service)
    {
        //   dd($service);
        $service->name=$request->name;
        $service->description=$request->description;
        $service->price=$request->price;
        $service->duration=$request->duration;

        // delete old image 
        if ($service->getRawOriginal('image') && $request->hasFile('image') && file_exists(public_path($service->getRawOriginal('image')))) {
            unlink(public_path($service->getRawOriginal('image')));
        }
        // handel image 
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $service->image = '/images/'.$filename;
        }
        $service->save();
        
        return response()->json([
            'success' => true,
            'data' => $service,
            'message' => 'Service updated successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        // delete old image 
        if ($service->getRawOriginal('image') && file_exists(public_path($service->getRawOriginal('image')))) {
            unlink(public_path($service->getRawOriginal('image')));
        }
        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully'
        ],200);
    }
}
