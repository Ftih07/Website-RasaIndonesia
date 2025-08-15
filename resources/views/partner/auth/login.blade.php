@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Partner Login</h1>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('partner.login.submit') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Username / Email</label>
                <input type="text" name="username" value="{{ old('username') }}" 
                    class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold">
                Login
            </button>
        </form>
    </div>
</div>
@endsection
