@extends('layouts.layout')

@section('content')
<!-- table light -->
<div class="table-responsive">
    <table class="table-hover">
        <thead>
            <tr class="!bg-transparent dark:!bg-transparent">
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
           
            <tr>
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
            </tr>
          
        </tbody>
    </table>
</div>

<!-- script -->
{{-- <script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("form", () => ({
            tableData: [{
                    id: 1,
                    name: 'John Doe',
                    email: 'johndoe@yahoo.com',
                    date: '10/08/2020',
                    sale: 120,
                    status: 'Complete',
                    register: '5 min ago',
                    progress: '40%',
                    position: 'Developer',
                    office: 'London'
                },
                {
                    id: 2,
                    name: 'John Doe',
                    email: 'johndoe@yahoo.com',
                    date: '10/08/2020',
                    sale: 120,
                    status: 'Complete',
                    register: '5 min ago',
                    progress: '40%',
                    position: 'Developer',
                    office: 'London'
                },
                
        ]}));
    });
</script> --}}
@endsection