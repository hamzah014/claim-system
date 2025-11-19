@extends('adminlte::page-base')

@section('title', 'Admin Panel Login - Restricted Access')

@section('content')

    <div class="p-10 space-y-8 transition duration-300 ease-in-out bg-white border border-gray-100 shadow-xl dark:bg-gray-800 rounded-2xl hover:shadow-2xl dark:border-gray-700">
        
        <header class="space-y-2 text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-teal-600 rounded-full shadow-lg">
                
                {{-- Logo Image --}}
                @if (config('adminlte.auth_logo.enabled', false))
                    <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                         alt="{{ config('adminlte.auth_logo.img.alt') }}"
                         @if (config('adminlte.auth_logo.img.class', null))
                            class="{{ config('adminlte.auth_logo.img.class') }}"
                         @endif
                         @if (config('adminlte.auth_logo.img.width', null))
                            width="{{ config('adminlte.auth_logo.img.width') }}"
                         @endif
                         @if (config('adminlte.auth_logo.img.height', null))
                            height="{{ config('adminlte.auth_logo.img.height') }}"
                         @endif>
                @else
                    <img src="{{ asset(config('adminlte.logo_img')) }}"
                         alt="{{ config('adminlte.logo_img_alt') }}" height="50">
                @endif
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                ADMINISTRATION
            </h1>
        </header>

        <form action="{{ route('admin.login.auth') }}" method="post" class="space-y-6">
            @csrf

            {{-- Email field --}}
            <div>
                <label for="email" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Admin Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                    </div>
                    <input type="email" name="email" id="email" 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                                  focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-150 text-sm
                                  @error('email') border-red-500 ring-red-500 @enderror"
                           value="{{ old('email') }}" 
                           placeholder="admin@yourdomain.com" 
                           required autofocus>
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password field --}}
            <div>
                <label for="password" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="password" name="password" id="password" 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                                  focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-150 text-sm
                                  @error('password') border-red-500 ring-red-500 @enderror"
                           placeholder="••••••••" 
                           required>
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between pt-2">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="block ml-2 text-sm text-gray-900 select-none dark:text-gray-300">
                        Remember Session
                    </label>
                </div>

                <div class="text-sm">
                    @if (Route::has('admin.password.request'))
                        <a href="{{ route('admin.password.request') }}" class="font-medium text-teal-600 transition duration-150 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300">
                            Forgot Password?
                        </a>
                    @endif
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-base font-semibold text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-teal-500 dark:focus:ring-offset-gray-800 transition duration-300 ease-in-out transform hover:scale-[1.01] active:scale-95">
                    LOG IN <i class="text-lg ms-2 fas fw fa-angle-right"></i>
                </button>
            </div>
        </form>
        
    </div>

@stop