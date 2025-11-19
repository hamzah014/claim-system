@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    
    {{-- DataTables --}}
    <link href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/datatables-plugins/rowgroup/css/rowGroup.bootstrap4.min.css') }}" rel="stylesheet" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    
    @stack('css')
    @yield('css')

    <style>

        .table-responsive {
            width: 100%;
        }

    </style>

@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation --}}
        @if($layoutHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')

    {{-- DataTables --}}
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>

    {{-- DataTables Plugins --}}
    <script src="{{ asset('vendor/datatables-plugins/rowgroup/js/dataTables.rowGroup.js') }}"></script>
    <script src="{{ asset('vendor/datatables-plugins/rowgroup/js/rowGroup.bootstrap4.min.js') }}"></script>
    
    @stack('js')
    @yield('js')
    
    <script>
        $(document).ready(function () {

            @if(session('success'))
                console.log('Success message:', '{{ session('success') }}');
                let successMessage = '{{ session('success') }}';
                alert(successMessage);
            @endif
            
            @if(session('error'))
                console.log('Error message:', '{{ session('error') }}');
                let errorMessage = '{{ session('error') }}';
                alert(errorMessage);
            @endif


        });
    </script>
@stop
