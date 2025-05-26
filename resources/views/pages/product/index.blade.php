@extends('layouts.layout')

@section('content')
<!-- table light -->
<div class="mt-5 table-responsive">
    <div class="mt-5 table-header">
        <span class="mb-6 flex items-center justify-between">
            <ol class="ms-3 inline-flex text-gray-500 font-semibold dark:text-white-dark">
                <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
                <li class="before:content-['/'] before:px-1.5"><a
                        class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Products</a>
                </li>
            </ol>
           @can('create product')
           <div class="mt-3 mx-3 inline-flex items-center justify-end gap-2">
            <button type="button" >
                <a class="btn btn-primary flex" href="{{ route('productweb.create') }}">Add</a>
                
            </button>

        </div>
           @endcan
        </span>
       
        {{-- <div class="flex items-center gap-2">
            <button type="button" class="btn btn-primary"><a href="{{ route('productweb.create') }}">Add Product</a></button>
           
        </div> --}}
    <table id="my-table-id" class="table-hover">
        <thead>
            <tr class="!bg-transparent dark:!bg-transparent">
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Stock</th>
               @canany(['update product','delete product'])
                <th>Action</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            
            @foreach ($products as $product )
            <tr>
                <td >{{ $product->name }}</td>
                <td>
                 <img src="{{ $product->image }}" alt="Product Image" class="w-12 h-12 rounded-full max-w-none">
                </td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock_quantity }}</td>
                
              @canany(['update product','delete product'])
                <td>
                    @php
                        $productweb = $product->id;
                    @endphp
                <button>
                    <a href="{{ route('productweb.edit', $productweb) }}" class="self-baseline">
                        <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>

                    </a>
                </button>
                    
                  
                    <form action="{{ route('productweb.destroy',$productweb) }}" class="delete-form inline ml-2" method="POST"> 
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