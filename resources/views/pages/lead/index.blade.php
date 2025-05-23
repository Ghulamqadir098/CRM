@extends('layouts.layout')

@section('content')
    <!-- table light -->
    @can('read all leads')
        <div class="mt-5 table-responsive">
            <div class="mt-5 table-header">
                <span class="mb-6 flex items-center justify-between">
                    <ol class="ms-3 inline-flex text-gray-500 font-semibold dark:text-white-dark">
                        <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
                        <li class="before:content-['/'] before:px-1.5"><a
                                class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Leads</a>
                        </li>
                    </ol>
                    <div class="mx-3 inline-flex items-center justify-end gap-2">
                        <button type="button">
                            <a class="btn btn-primary flex" href="{{ route('leadweb.create') }}">Add

                            </a>
                        </button>

                    </div>
                </span>


                <table id="my-table-id" class="table-hover">
                    <thead>
                        <tr class="!bg-transparent dark:!bg-transparent">
                            <th>Agent</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>phone</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($leads as $lead)
                            <tr>
                                <td>{{ $lead->user->name }}</td>
                                <td class="whitespace-nowrap">{{ $lead->name }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td>
                                    @php
                                        $leadweb = $lead->id;
                                    @endphp
                                    <button>
                                        <a href="{{ route('leadweb.edit', $leadweb) }}" class="self-baseline">
                                            <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>

                                        </a>
                                    </button>

                                    <form action="{{ route('leadweb.destroy', $lead->id) }}" class="delete-form inline ml-2"
                                        method="POST">
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
        @endcan
        @can('read own leads')
            <div class="mt-5 table-responsive">
                <div class="mt-5 table-header">
                    <span class="mb-6 flex items-center justify-between">
                        <ol class="ms-3 inline-flex text-gray-500 font-semibold dark:text-white-dark">
                            <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
                            <li class="before:content-['/'] before:px-1.5"><a
                                    class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Leads</a>
                            </li>
                        </ol>
                        <div class="mx-3 inline-flex items-center justify-end gap-2">
                            <button type="button">
                                <a class="btn btn-primary flex" href="{{ route('leadweb.create') }}">Add

                                </a>
                            </button>

                        </div>
                    </span>
                    <table id="my-table-id" class="table-hover">
                        <thead>
                            <tr class="!bg-transparent dark:!bg-transparent">
                                <th>Agent</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>phone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($leads as $lead)
                                @if (auth()->user()->hasRole('agent') && $lead->user_id !== auth()->id())
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $lead->user->name }}</td>
                                    <td class="whitespace-nowrap">{{ $lead->name }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->phone }}</td>
                                    <td class="text-center">
                                        @php
                                            $leadweb = $lead->id;
                                        @endphp



                                        <button>
                                            <a href="{{ route('leadweb.edit', $leadweb) }}" class="self-baseline">
                                                <i class="fa-solid fa-pen fa-lg" style="color: #74C0FC;"></i>

                                            </a>
                                        </button>
                                        <form action="{{ route('leadweb.destroy', $lead->id) }}" class="delete-form inline ml-2"
                                            method="POST">
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
            @endcan


        @endsection
