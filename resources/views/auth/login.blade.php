@extends('layouts.guest')

@section('content')
<div class="bg-gray-100 flex justify-center items-center h-screen">
    <!-- Left: Image -->
    <div class="w-1/2 h-screen hidden lg:flex justify-center items-center">
        <img src="{{ asset('logo-text.png') }}" alt="Placeholder Image" class="max-w-full max-h-full">
    </div>


    <!-- Right: Login Form -->
    <div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
        <h1 class="text-2xl font-semibold mb-4">Login</h1>

        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600">Email</label>
                <input id="email" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                       type="email" name="email" value="{{ old('email') }}" required autofocus />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input id="password" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                       type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="mb-4 flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="text-blue-500">
                <label for="remember_me" class="text-gray-600 ml-2">Remember Me</label>
            </div>

            <!-- Forgot Password -->
            <div class="mb-6 text-blue-500">
                @if (Route::has('password.request'))
                    <a class="hover:underline" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full">
                Login
            </button>
        </form>

        <!-- Sign up Link -->
     
    </div>
</div>
@endsection
