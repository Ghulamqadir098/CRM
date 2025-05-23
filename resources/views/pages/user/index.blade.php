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
                    </ol>
                    <div class="mx-3 flex items-center justify-end gap-2">
                        <button type="button" class="btn btn-outline-primary">
                            <a href="{{ route('agent.register') }}">Add</a>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:ml-1.5 rtl:mr-1.5">
                                <path
                                    d="M15.2869 3.15178L14.3601 4.07866L5.83882 12.5999L5.83881 12.5999C5.26166 13.1771 4.97308 13.4656 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.32181 19.8021L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L4.19792 21.6782L7.47918 20.5844L7.47919 20.5844C8.25353 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5344 19.0269 10.8229 18.7383 11.4001 18.1612L11.4001 18.1612L19.9213 9.63993L20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178Z"
                                    stroke="currentColor" stroke-width="1.5"></path>
                                <path opacity="0.5"
                                    d="M14.36 4.07812C14.36 4.07812 14.4759 6.04774 16.2138 7.78564C17.9517 9.52354 19.9213 9.6394 19.9213 9.6394M4.19789 21.6777L2.32178 19.8015"
                                    stroke="currentColor" stroke-width="1.5"></path>
                            </svg>
                        </button>

                    </div>
                </span>
                <span class="w-6/12">
                    <table id="my-table-id" class="table-hover">
                        <thead>
                            <tr class="!bg-transparent dark:!bg-transparent">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($agents as $agent)
                                <tr>
                                    <td>{{ $agent->id }}</td>
                                    <td>
                                        <div class="flex items-center w-max">
                                            <img class="w-9 h-9 rounded-full ltr:mr-2 rtl:ml-2 object-cover"
                                                src="{{ $agent->image }}">{{ $agent->name }}
                                        </div>
                                    </td>

                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->created_at }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('user.delete', $agent->id) }}" class="delete-form"
                                            method="POST">
                                            @csrf
                                            <button type="submit">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5"
                                                        d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M3 6.38597C3 5.90152 3.34538 5.50879 3.77143 5.50879L6.43567 5.50832C6.96502 5.49306 7.43202 5.11033 7.61214 4.54412C7.61688 4.52923 7.62232 4.51087 7.64185 4.44424L7.75665 4.05256C7.8269 3.81241 7.8881 3.60318 7.97375 3.41617C8.31209 2.67736 8.93808 2.16432 9.66147 2.03297C9.84457 1.99972 10.0385 1.99986 10.2611 2.00002H13.7391C13.9617 1.99986 14.1556 1.99972 14.3387 2.03297C15.0621 2.16432 15.6881 2.67736 16.0264 3.41617C16.1121 3.60318 16.1733 3.81241 16.2435 4.05256L16.3583 4.44424C16.3778 4.51087 16.3833 4.52923 16.388 4.54412C16.5682 5.11033 17.1278 5.49353 17.6571 5.50879H20.2286C20.6546 5.50879 21 5.90152 21 6.38597C21 6.87043 20.6546 7.26316 20.2286 7.26316H3.77143C3.34538 7.26316 3 6.87043 3 6.38597Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z"
                                                        fill="currentColor"></path>
                                                </svg>
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
        @can('create customer')
            <div class="table-responsive mt-5">
                <div class="table-header">
                    {{-- <h2 class="text-lg font-medium">Customers</h2> --}}
                    <div class="mt-3 mx-3 flex items-center justify-end gap-2">
                        <button type="button" class="btn btn-outline-primary">
                            <a href="{{ route('customer.register') }}">Add</a>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:ml-1.5 rtl:mr-1.5">
                                <path
                                    d="M15.2869 3.15178L14.3601 4.07866L5.83882 12.5999L5.83881 12.5999C5.26166 13.1771 4.97308 13.4656 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.32181 19.8021L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L4.19792 21.6782L7.47918 20.5844L7.47919 20.5844C8.25353 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5344 19.0269 10.8229 18.7383 11.4001 18.1612L11.4001 18.1612L19.9213 9.63993L20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178Z"
                                    stroke="currentColor" stroke-width="1.5"></path>
                                <path opacity="0.5"
                                    d="M14.36 4.07812C14.36 4.07812 14.4759 6.04774 16.2138 7.78564C17.9517 9.52354 19.9213 9.6394 19.9213 9.6394M4.19789 21.6777L2.32178 19.8015"
                                    stroke="currentColor" stroke-width="1.5"></path>
                            </svg>
                        </button>

                    </div>
                    {{-- <div class="flex items-center gap-2">
                        <button type="button" class="btn btn-primary"><a href="{{ route('customer.register') }}">Add
                                Customer</a></button>
                      
                    </div> --}}
                    <table id="my-table-id-2" class="table-hover">
                        <thead>
                            <tr class="!bg-transparent dark:!bg-transparent">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>
                                        <div class="flex items-center w-max">
                                            <img class="w-9 h-9 rounded-full ltr:mr-2 rtl:ml-2 object-cover"
                                                src="{{ $customer->image }}">{{ $customer->name }}
                                        </div>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at }}</td>
                                    <td class="text-center">
                                        <button>
                                            <a href="{{ route('serviceweb.edit', $service) }}" class="self-baseline">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4001 18.1612L11.4001 18.1612L18.796 10.7653C17.7894 10.3464 16.5972 9.6582 15.4697 8.53068C14.342 7.40298 13.6537 6.21058 13.2348 5.2039L5.83882 12.5999L5.83879 12.5999C5.26166 13.1771 4.97307 13.4657 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L7.47918 20.5844C8.25351 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5343 19.0269 10.823 18.7383 11.4001 18.1612Z" fill="currentColor"></path>
                                                    <path d="M20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178L14.3999 4.03882C14.4121 4.0755 14.4246 4.11268 14.4377 4.15035C14.7628 5.0875 15.3763 6.31601 16.5303 7.47002C17.6843 8.62403 18.9128 9.23749 19.85 9.56262C19.8875 9.57563 19.9245 9.58817 19.961 9.60026L20.8482 8.71306Z" fill="currentColor"></path>
                                                </svg>
                                            </a>
                                           </button>
                                        <form action="{{ route('user.delete', $customer->id) }}" class="delete-form"
                                            method="POST">
                                            @csrf
                                            <button type="submit">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.5"
                                                        d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z"
                                                        fill="currentColor"></path>
                                                    <path
                                                        d="M3 6.38597C3 5.90152 3.34538 5.50879 3.77143 5.50879L6.43567 5.50832C6.96502 5.49306 7.43202 5.11033 7.61214 4.54412C7.61688 4.52923 7.62232 4.51087 7.64185 4.44424L7.75665 4.05256C7.8269 3.81241 7.8881 3.60318 7.97375 3.41617C8.31209 2.67736 8.93808 2.16432 9.66147 2.03297C9.84457 1.99972 10.0385 1.99986 10.2611 2.00002H13.7391C13.9617 1.99986 14.1556 1.99972 14.3387 2.03297C15.0621 2.16432 15.6881 2.67736 16.0264 3.41617C16.1121 3.60318 16.1733 3.81241 16.2435 4.05256L16.3583 4.44424C16.3778 4.51087 16.3833 4.52923 16.388 4.54412C16.5682 5.11033 17.1278 5.49353 17.6571 5.50879H20.2286C20.6546 5.50879 21 5.90152 21 6.38597C21 6.87043 20.6546 7.26316 20.2286 7.26316H3.77143C3.34538 7.26316 3 6.87043 3 6.38597Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z"
                                                        fill="currentColor"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </button>
                                        </form>

                                    </td>
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
