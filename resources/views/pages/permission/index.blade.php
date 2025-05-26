@extends('layouts.layout')

@section('content')
<!-- table light -->
<div class="mt-5 table-responsive">
    <div class="mt-5 table-header">
       <span class="mb-6 flex items-center justify-between">
        <ol class="ms-3 inline-flex text-gray-500 font-semibold dark:text-white-dark">
            <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
            <li class="before:content-['/'] before:px-1.5"><a
                    class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Settings</a>
            </li>
            <li class="before:content-['/'] before:px-1.5"><a
                class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Permissions</a>
        </li>
        </ol>
      @can('create role')
      <div class=" mx-3 inline-flex items-center justify-end gap-2">
        <button type="button">
            <a class="btn btn-primary flex" href="{{ route('permissions.create') }}">Add</a>
        </button>
    </div>
      @endcan
       </span>
       
    <table class="table-hover" id="my-table-id">
        <thead>
            <tr class="!bg-transparent dark:!bg-transparent">
                <th>Permissions</th>
                <th>Assigned Permissions</th>
                <th>Created At</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($roles as $role )
            <tr>
                <td >{{ $role->name }}</td>
                <td>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        @foreach ($role->permissions->sortBy('name') as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                <td>
                    {{ $role->created_at->format('d-m-Y') }}
                </td>
              
                <td>
                   
                   <button>
                    <a href="{{ route('roles.edit', $role) }}" class="self-baseline">
                        <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>
                    </a>
                   </button>
                    
                   
                    <form action="{{ route('roles.destroy',$role) }}" class="inline ml-2 delete-form" method="POST"> 
                        @method('DELETE')
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-trash-can fa-lg" style="color: #e60000;"></i>

                    </button>
                </form>
                </td>    

            @endforeach

        
          
        </tbody>
    </table>
</div>



@endsection