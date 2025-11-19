@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="flex items-center justify-center min-h-screen font-sans antialiased bg-gray-50 dark:bg-gray-900">

        <div class="absolute inset-0 z-0 opacity-20 bg-gradient-to-br from-indigo-100 to-white dark:from-gray-900 dark:to-gray-800"></div>

        <div class="z-10 w-full max-w-md">
            @yield('content')
        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
