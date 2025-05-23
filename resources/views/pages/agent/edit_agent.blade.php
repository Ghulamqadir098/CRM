@extends('layouts.layout')

@section('content')
<div class="my-auto">
    <form action="{{ route('admin.agent.update', $agent) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @csrf
        <h6 class="mb-5 text-lg font-bold">Update Agent</h6>
        {{-- <p class="mb-5 text-base font-bold leading-normal text-white-dark">Enter details to update Agent</p> --}}
        
        <div class="flex flex-col sm:flex-row">
          
            <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name">Full Name*</label>
                    <input id="name" name="name" type="text" value="{{ $agent->name }}" placeholder="Enter Name" class="form-input">
                    @error('name')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email">Email*</label>
                    <input id="email" name="email" type="email" value="{{ $agent->email }}" placeholder="Enter Email" class="form-input">
                    @error('email')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="image">Image</label>

                    <input name="image" type="file" accept="image/*" class="form-input mt-2 w-full">
                    <img src="{{ $agent->image ?? 'assets/images/profile-34.jpeg' }}" alt="image" class="mx-auto h-20 w-20 rounded-full object-cover md:h-32 md:w-32">
                  
                    @error('image')
                        <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
              
                <div class="mt-3 flex justify-end sm:col-span-2">
                    <button class="mr-3">
                        <a href="{{ route('agent.index') }}" class="btn btn-md btn-danger">Cancel</a>
                    </button>
                    <button type="submit"><a class="btn btn-primary">Update</a></button>
                    
                </div>
            </div>
        </div>
    </form>
</div>
 
@endsection
