<!-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

<x-auth-session-status class="mb-4" :status="session('status')" />

<x-auth-validation-errors class="mb-4" :errors="$errors" />

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
        <x-label for="email" :value="__('Email')" />

        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
    </div>

    <div class="mt-4">
        <x-label for="password" :value="__('Password')" />

        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
    </div>

    <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
    </div>

    <div class="flex items-center justify-end mt-4">
        @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
        @endif

        <x-button class="ml-3">
            {{ __('Login') }}
        </x-button>
    </div>
</form>
</x-auth-card>
</x-guest-layout> -->




<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('/css/all.css')) }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
        
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100 m-0">
                    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                        <div class="card col-lg-4 mx-auto">
                            <div class="card-body px-5 py-5">
                                <h3 class="card-title text-left mb-3">Login</h3>
                                <form action="{{ route('login') }}" @submit.prevent="submit">
                                @csrf
                                    <div class="form-group">
                                        <label>Username or email *</label>
                                        <input v-model="email" type="text" class="form-control p_input"/>
                                        <!-- <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus /> -->
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input v-model="password" type="password" class="form-control p_input"/>
                                        <!-- <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" /> -->
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn">
                                            Login {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            </html>