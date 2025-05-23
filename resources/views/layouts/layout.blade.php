<!DOCTYPE html>
<html lang="en" dir="ltr">

@include('includes.head')

<body x-data="main" class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased"
    :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
        $store.app.menu, $store.app.layout, $store.app.rtlClass
    ]">
@include('includes.modal')
    {{-- Widgets --}}
    @include('includes.widgets')
    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        {{-- Sidebar --}}
        @include('includes.sidebar')
        <div class="main-content flex min-h-screen flex-col">
             {{-- Header  --}}
            @include('includes.header')
        @yield('content')
        {{-- Footer --}}
       @include('includes.footer')
        </div>
    </div>

    {{-- Scripts  --}}
    @include('includes.scripts')

    @yield('scripts')
    {{-- Confirm script  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('submit', function (e) {
                if (e.target && e.target.matches('.delete-form')) {
                    e.preventDefault(); // Stop form from submitting
    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            e.target.submit(); // Manually submit if confirmed
                        }
                    });
                }
            });
        });
    </script>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    
        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    
        @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    
</body>

</html>
