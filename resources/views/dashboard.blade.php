<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* General Form Styles */
        .form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.5rem;
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .mb-10 {
            margin-bottom: 2.5rem;
        }

        .bg-light-info {
            background-color: #e0f7fa;
            padding: 2rem;
            border-radius: 8px;
        }

        .text-info {
            color: #007bff;
        }

        .fv-row {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-control-lg {
            font-size: 1.25rem;
        }

        .form-control-solid {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .text-dark {
            color: #333;
        }

        .text-gray-400 {
            color: #888;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fs-4 {
            font-size: 1.25rem;
        }

        .link-primary {
            color: #007bff;
            text-decoration: none;
        }

        .link-primary:hover {
            text-decoration: underline;
        }

        .form-check {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .form-check-label {
            font-size: 1rem;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #fff;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            background-color: #007bff;
            border: 1px solid #007bff;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .w-100 {
            width: 100%;
        }

        .mb-5 {
            margin-bottom: 1.25rem;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
            color: #333;
        }

        .btn-light:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }
    </style>
    <x-slot name="header" style="background-color: deeppink;">
        <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate id="kt_sign_in_form">
            @csrf
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard') }}</h2>
            
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">{{ __('Sign In to Metronic') }}</h1>
                <div class="text-gray-400 fw-bold fs-4">
                    {{ __('New Here?') }}
                    <a href="{{ route('register') }}" class="link-primary fw-bolder">{{ __('Create an Account') }}</a>
                </div>
            </div>
        
            <div class="mb-10 bg-light-info p-8 rounded">
                <div class="text-info">
                    Use account <strong>admin@demo.com</strong> and password <strong>demo</strong> to continue.
                </div>
            </div>
        
            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
                <input class="form-control form-control-lg form-control-solid" type="email" name="email" autocomplete="off" value="{{ old('email', 'demo@demo.com') }}" required autofocus />
            </div>
        
            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">{{ __('Forgot Password?') }}</a>
                    @endif
                </div>
                <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" value="demo" required />
            </div>
        
            <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" name="remember" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">{{ __('Remember me') }}</span>
                </label>
            </div>
        
            <div class="text-center">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    {{-- @include('partials.general._button-indicator', ['label' => __('Continue')]) --}}
                    {{ __('Continue') }}
                </button>
        
                <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
        
                <a href="{{ url('/auth/redirect/google') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                    {{-- <img alt="Logo" src="{{ Url() . '') }}" class="h-20px me-3"/> --}}
                    {{ __('Continue with Google') }}
                </a>
        
                <a href="{{ url('/auth/redirect/facebook') }}?redirect_uri={{ url()->previous() }}" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5">
                    {{-- <img alt="Logo" src="{{ Url() ) }}" class="h-20px me-3"/> --}}
                    {{ __('Continue with Facebook') }}
                </a>
            </div>
        </form>
        
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
