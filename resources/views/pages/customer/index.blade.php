@extends('layouts.layout')

@section('content')
    <!-- table light -->
        @can('read all users')
            <div class="table-responsive mt-5">
                <div class="table-header">
                <span class="mb-6 flex items-center justify-between">

                    <ol class="ms-3 inline-flex text-gray-500 font-semibold dark:text-white-dark">
                        <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
                        <li class="before:content-['/'] before:px-1.5"><a
                                class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Users</a>
                        </li>
                        <li class="before:content-['/'] before:px-1.5"><a
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Customers</a>
                    </li>
                    </ol>
                    <div class="mx-3 inline-flex items-center justify-end gap-2">
                        @can('create customer')
                        <button type="button">
                            <a class="btn btn-primary flex"  href="{{ route('admin.customer.register') }}">Add
                           
                        </a>
                        </button>
                        @endcan
                        

                    </div>
                </span>                    
                    <table id="my-table-id-2" class="table-hover">
                        <thead>
                            <tr class="!bg-transparent dark:!bg-transparent">
                                
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                @canany(['update customer','delete customer'])
                                <th class="text-center">Action</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($customers as $customer)
                                <tr>
                                  
                                    <td>
                                        <div class="flex items-center w-max">
                                           {{ $customer->name }}
                                        </div>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at }}</td>
                                @canany(['update customer','delete customer'])
                                    
                                    <td >
                                        <button class="ml-2">
                                            <a href="{{ route('customer.view', $customer) }}" class="self-baseline">
                                                <i class="fa-solid fa-eye" style="color: #FFD43B;"></i>

                                            </a>
                                           </button>
                                        <button class="ml-2" onclick="openModal({{ $customer->id }})">
                                            <i class="fa-solid fa-lock" style="color: #f10404;"></i>
                                        </button>
                                        <button class="ml-2">
                                            <a href="{{ route('admin.customer.edit', $customer) }}" class="self-baseline">
                                                <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>
                                            </a>
                                           </button>
                                        <form action="{{ route('user.delete', $customer->id) }}" class="inline ml-2 delete-form"
                                            method="POST">
                                            @csrf
                                            <button type="submit">
                                                <i class="fa-solid fa-trash-can fa-lg" style="color: #e60000;"></i>
                                            </button>
                                        </form>

                                    </td>
                                   @endcanany 
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            @endcan
            @can('read own customers')
                <div class="table-responsive mt-5">
                    <div class="table-header">
                        <h2 class="text-lg font-medium">My Customers</h2>
                        <div class="flex items-center gap-2">

                        </div>
                        <table id="my-table-id-3" class="table-hover">
                            <thead>
                                <tr class="!bg-transparent dark:!bg-transparent">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($customers as $customer)
                                    @if (auth()->user()->hasRole('agent') && $customer->agent_id !== auth()->id())
                                        @continue
                                    @endif

                                    <tr>
                                        <td>{{ $customer->id }}</td>
                                        <td class="whitespace-nowrap">{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->created_at }}</td>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                @endcan

               

                @endsection


