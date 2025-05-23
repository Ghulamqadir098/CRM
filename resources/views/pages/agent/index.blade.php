@extends('layouts.layout')

@section('content')
    <!-- table light -->
    @can('create agent')
        <div class="mt-5 table-responsive">
            <div class="mt-5 table-header">
                <span class="mb-6 flex items-center justify-between">
                    <ol class="ms-3 flex text-gray-500 font-semibold dark:text-white-dark">
                        <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
                        <li class="before:content-['/'] before:px-1.5"><a
                                class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Users</a>
                        </li>
                        <li class="before:content-['/'] before:px-1.5"><a
                            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Agents</a>
                    </li>
                    </ol>
                    <div class="mx-3 flex items-center justify-end gap-2">
                        <button type="button">
                            {{-- <a href="{{ route('agent.register') }}">Add</a> --}}
                            <a class="btn btn-primary flex" href="{{ route('admin.agent.register') }}">Add

                            
                        </a>
                        </button>

                    </div>
                </span>
                <span class="w-6/12">
                    <table id="my-table-id" class="table-hover">
                        <thead>
                            <tr class="!bg-transparent dark:!bg-transparent">
                              
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($agents as $agent)
                                <tr>
                                    
                                    <td>
                                        <div class="flex items-center w-max">
                                            {{ $agent->name }}
                                        </div>
                                    </td>

                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->created_at }}</td>
                                    <td>
                                        <button class="ml-2">
                                            <a href="{{ route('agent.view', $agent) }}" class="self-baseline">
                                                <i class="fa-solid fa-eye" style="color: #FFD43B;"></i>

                                            </a>
                                           </button>
                                        <button class="ml-2" onclick="openModal({{ $agent->id }})">
                                            <i class="fa-solid fa-lock" style="color: #f10404;"></i>
                                        </button>
                                      
                                        <button class="ml-2">
                                            <a href="{{ route('admin.agent.edit', $agent) }}" class="self-baseline">
                                                <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>

                                            </a>
                                           </button>
                                        <form action="{{ route('user.delete', $agent->id) }}" class=" inline ml-2 delete-form"
                                            method="POST">
                                            @csrf
                                            <button type="submit">
                                                <i class="fa-solid fa-trash-can fa-lg" style="color: #e60000;"></i>
                                               
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </span>
            </div>
        @endcan

        @can('read own agent')
            <div class="table-responsive">
                <div class="table-header">
                    <h2 class="text-lg font-medium">My Agent</h2>
                    <div class="flex items-center gap-2">
                    </div>
                    <table id="my-table-id-4" class="table-hover">
                        <thead>
                            <tr class="!bg-transparent dark:!bg-transparent">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($agents as $agent)
                                @if (auth()->user()->hasRole('customer') && $agent->id !== auth()->user()->agent_id)
                                    @continue
                                @endif

                                <tr>
                                    <td>{{ $agent->id }}</td>
                                    <td class="whitespace-nowrap">{{ $agent->name }}</td>
                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->created_at }}</td>

                                </tr>
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
            @endcan


        @endsection

  