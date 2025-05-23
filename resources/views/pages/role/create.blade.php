@extends('layouts.layout')

@section('content')
<!-- input text -->

<ol class="ms-3 mt-5 flex text-gray-500 font-semibold dark:text-white-dark">
    <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
    <li class="before:content-['/'] before:px-1.5"><a
            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Settings</a>
    </li>
    <li class="before:content-['/'] before:px-1.5"><a
        class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Roles</a>
</li>
</ol>
<div class="my-auto">
    <form action="{{ route('roles.store') }}" method="POST" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @csrf
        <h6 class="mb-5 text-lg font-bold">Add Role</h6>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Row 1 -->
            <div>
                <label for="name">Name*</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Role name" class="form-input">
                @error('name')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="Permissions">Permissions*</label>
                <select id="size" multiple name="permissions[]" >
                    
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}" class="!px-5">{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
            
           

        </div>

        <div class="mt-5 flex justify-end">
            <button class="mr-3">
                <a href="{{ route('roles.index') }}" class="btn btn-md btn-danger">Cancel</a>
            </button>
            <button type="submit" class="btn btn-primary z-50">Add</button>
        </div>
    </form>
</div>



@endsection


@section('scripts')
<script src=/assets/js/jquery.multi-select.js></script>
<script>
    $('#size').multiSelect();
</script>


@endsection