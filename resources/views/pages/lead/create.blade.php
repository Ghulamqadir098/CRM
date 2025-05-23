@extends('layouts.layout')

@section('content')
<!-- input text -->

<ol class="ms-3 mt-5 flex text-gray-500 font-semibold dark:text-white-dark">
    <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
    <li class="before:content-['/'] before:px-1.5"><a
            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Leads</a>
    </li>
</ol>
<div class="my-auto">
    <form action="{{ route('leadweb.store') }}" method="POST" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @csrf
        <h6 class="mb-5 text-lg font-bold">Add Lead</h6>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name">Name*</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Some Text..." class="form-input">
                @error('name')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="email">Email*</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Some Text..." class="form-input" >
                @error('email')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="phone">Phone*</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Some Text..." class="form-input" >
                @error('phone')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            @can('read all leads')
            <div>
                <label for="agent">Agent*</label>
                <select name="user_id" id="agent" class="form-select">
                    <option value="">Select Agent</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endcan
            
            @can('read own leads')
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            @endcan
            
            <div>
                <label for="status">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="new">New</option>
                    <option value="contacted">Contacted</option>
                    <option value="qualified">Qualified</option>
                    <option value="lost">Lost</option>
                </select>
                @error('status')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="source">Source</label>
                <select name="source" id="source" class="form-select">
                    <option value="">Select Source</option>
                    <option value="website">Website</option>
                    <option value="referral">Referral</option>
                    <option value="social_media">Social Media</option>
                    <option value="event">Event</option>
                    <option value="other">Other</option>
                </select>
                @error('source')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button class="mr-3">
                <a href="{{ route('leadweb.index') }}" class="btn btn-md btn-danger">Cancel</a>
            </button>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</div>



@endsection