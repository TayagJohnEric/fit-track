@extends('layout.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit User</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->userProfile->first_name ?? '') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->userProfile->last_name ?? '') }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->userProfile->date_of_birth ?? '') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Sex</label>
                    <select name="sex" class="w-full border rounded p-2" required>
                        @foreach (['Male', 'Female', 'Other'] as $sex)
                            <option value="{{ $sex }}" @if(old('sex', $user->userProfile->sex ?? '') == $sex) selected @endif>{{ $sex }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Height (cm)</label>
                    <input type="number" step="0.1" name="height_cm" value="{{ old('height_cm', $user->userProfile->height_cm ?? '') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Weight (kg)</label>
                    <input type="number" step="0.1" name="current_weight_kg" value="{{ old('current_weight_kg', $user->userProfile->current_weight_kg ?? '') }}" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block text-gray-700">Daily Budget (optional)</label>
                    <input type="number" step="0.01" name="daily_budget" value="{{ old('daily_budget', $user->userProfile->daily_budget ?? '') }}" class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block text-gray-700">Fitness Goal</label>
                    <select name="fitness_goal_id" class="w-full border rounded p-2" required>
                        @foreach (\App\Models\FitnessGoal::all() as $goal)
                            <option value="{{ $goal->id }}" @selected(old('fitness_goal_id', $user->userProfile->fitness_goal_id ?? '') == $goal->id)>
                                {{ $goal->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Experience Level</label>
                    <select name="experience_level_id" class="w-full border rounded p-2" required>
                        @foreach (\App\Models\ExperienceLevel::all() as $level)
                            <option value="{{ $level->id }}" @selected(old('experience_level_id', $user->userProfile->experience_level_id ?? '') == $level->id)>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700">Preferred Workout Type</label>
                    <select name="preferred_workout_type_id" class="w-full border rounded p-2" required>
                        @foreach (\App\Models\WorkoutType::all() as $type)
                            <option value="{{ $type->id }}" @selected(old('preferred_workout_type_id', $user->userProfile->preferred_workout_type_id ?? '') == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update User</button>
        </form>
    </div>
</div>
@endsection
