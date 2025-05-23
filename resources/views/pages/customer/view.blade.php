@extends('layouts.layout')

@section('content')

<span class="mb-6 flex items-center justify-between">

    <ol class="ms-3 mt-5 inline-flex text-gray-500 font-semibold dark:text-white-dark">
        <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
        <li class="before:content-['/'] before:px-1.5"><a
                class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Users</a>
        </li>
        <li class="before:content-['/'] before:px-1.5"><a
            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Customers</a>
    </li>
    </ol>

</span> 
<div class="pt-5">
    <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-3 xl:grid-cols-4">
        <div class="panel">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Profile</h5>

            </div>
            <div class="mb-5">
                <div class="flex flex-col items-center justify-center">
                    <img src="{{ $customer->image }}" alt="image" class="mb-5 h-24 w-24 rounded-full object-cover">
                    <p class="text-xl font-semibold text-primary">{{ $customer->name }}</p>
                </div>
                <ul class="m-auto mt-5 flex max-w-[160px] flex-col space-y-4 font-semibold text-white-dark">
                  <h class="text-lg font-semibold dark:text-white-light">Roles</h>
                    @foreach ($roles as  $role)
                   <li class="flex items-center gap-2">
                    <i class="fa-solid fa-user"></i>
                    <span>{{ $role }}</span>
                </li>
                   @endforeach
                   <h class="text-lg font-semibold dark:text-white-light">Total Orders</h>
        
                  <li class="flex items-center gap-2">
                   <i class="fa-solid fa-user"></i>
                   {{-- format joining date --}}
                   <span>{{$ordersCount??"0"}}</span>
               </li>
                
                </ul>
              
            </div>
        </div>
        <div class="panel lg:col-span-2 xl:col-span-3">
            <div class="mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">Orders</h5>
            </div>
            <div class="mb-5">
                <div class="table-responsive font-semibold text-[#515365] dark:text-white-light">
                    <table id="my-table-id" class="whitespace-nowrap">
                        <thead>
                            <tr>
                                <th>Order#</th>
                                <th>order items count</th>
                                <th>Created at</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="dark:text-white-dark">
                          @foreach ($orders as $order)
                          <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                {{ $order->order_items_count }}
                            </td>
                            <td>
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                            <td> {{ $order->status }} </td>
                        </tr>
                          @endforeach
                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
</div>

@endsection