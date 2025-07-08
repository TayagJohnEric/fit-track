@extends('layout.admin')

@section('title', 'User Details')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">User Details</h2>

        <div class="mb-4">
            <strong>Name:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Role:</strong> {{ $user->role }}
        </div>

        @if ($user->userProfile)
        <div class="mb-4">
            <strong>First Name:</strong> {{ $user->userProfile->first_name }}<br>
            <strong>Last Name:</strong> {{ $user->userProfile->last_name }}<br>
            <strong>Sex:</strong> {{ $user->userProfile->sex }}<br>
            <strong>DOB:</strong> {{ $user->userProfile->date_of_birth }}<br>
            <strong>Height:</strong> {{ $user->userProfile->height_cm }} cm<br>
            <strong>Weight:</strong> {{ $user->userProfile->current_weight_kg }} kg<br>
        </div>
        @else
        <div class="text-gray-500 italic">No profile information.</div>
        @endif

        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit User</a>
    </div>
</div>
@endsection
