@extends('layouts.layout')

@section('content')
<!-- table light -->
<div class="mt-5 table-responsive">
    <div class="mt-5 table-header">
       <span class="mb-6 flex items-center justify-between">
        <ol class="ms-3 inline-flex text-gray-500 font-semibold dark:text-white-dark">
            <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
            <li class="before:content-['/'] before:px-1.5"><a
                    class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Services</a>
            </li>
        </ol>
        <div class=" mx-3 inline-flex items-center justify-end gap-2">
          @can('create service')
          <button type="button">
            <a class="btn btn-primary flex" href="{{ route('serviceweb.create') }}">Add</a>
           
        </button>  
          @endcan
           

        </div>
       </span>
        {{-- <div class="flex items-center gap-2">
            <button type="button" class="btn btn-primary"><a href="{{ route('serviceweb.create') }}">Add Service</a></button>
           
        </div> --}}
    <table class="table-hover" id="my-table-id">
        <thead>
            <tr class="!bg-transparent dark:!bg-transparent">
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Duration</th>
                @canany(['update service', 'delete service'])
                <th class="text-center">Action</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            
            @foreach ($services as $service )
            <tr>
                <td >{{ $service->name }}</td>
                <td class="whitespace-nowrap">
                 <img src="{{ $service->image }}" alt="Product Image" class="w-12 h-12 rounded-full max-w-none">
                </td>
                <td>{{ $service->price }}</td>
                <td>{{ $service->duration }}: Days</td>
                @canany(['update service', 'delete service'])
                <td>
                   
                   <button>
                    <a href="{{ route('serviceweb.edit', $service) }}" class="self-baseline">
                        <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>

                    </a>
                   </button>
                    
                   
                    <form action="{{ route('serviceweb.destroy',$service) }}" class="inline ml-2 delete-form" method="POST"> 
                        @method('DELETE')
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-trash-can fa-lg" style="color: #e60000;"></i>

                    </button>
                </form>
                </td>    
                @endcanany
            @endforeach

            {{-- <tr>
                <td >4</td>
                <td class="whitespace-nowrap">Vincent Carpenter</td>
                <td>vincent@gmail.com</td>
                <td>13/08/2020</td>
                <td class="text-center">
                    <button type="button">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-auto h-5 w-5">
                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </td>
            </tr> --}}
          
        </tbody>
    </table>
</div>



@endsection