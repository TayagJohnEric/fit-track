@extends('layout.onboarding')

@section('title', 'Step 2 - Fitness Preferences')
@section('subtitle', 'What are your fitness goals?')

@section('content')
<div class="space-y-6">
    <!-- Step Header -->
    <div class="text-center">
        <h2 class="text-xl font-bold text-gray-900">Fitness Preferences</h2>
        <p class="text-sm text-gray-600 mt-1">Step 2 of 3</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('onboarding.store.step2') }}" class="space-y-6">
        @csrf

        <!-- Fitness Goal -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                What's your primary fitness goal?
            </label>
            <div class="grid grid-cols-1 gap-3">
                @foreach($fitnessGoals as $goal)
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="fitness_goal_id" value="{{ $goal->id }}" 
                           class="sr-only peer" 
                           {{ old('fitness_goal_id', session('onboarding_step2.fitness_goal_id')) == $goal->id ? 'checked' : '' }}
                           required>
                    <div class="w-full p-4 text-left bg-white border-2 border-gray-200 rounded-lg peer-checked:bg-primary-50 peer-checked:border-primary-500 hover:border-gray-300 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $goal->name }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    @if($goal->name === 'Weight Loss')
                                        Focus on burning calories and losing body fat
                                    @else
                                        Focus on building muscle mass and strength
                                    @endif
                                </div>
                            </div>
                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-primary-500 peer-checked:border-primary-500 transition-colors"></div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('fitness_goal_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Experience Level -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                What's your fitness experience level?
            </label>
            <div class="grid grid-cols-1 gap-3">
                @foreach($experienceLevels as $level)
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="experience_level_id" value="{{ $level->id }}" 
                           class="sr-only peer" 
                           {{ old('experience_level_id', session('onboarding_step2.experience_level_id')) == $level->id ? 'checked' : '' }}
                           required>
                    <div class="w-full p-4 text-left bg-white border-2 border-gray-200 rounded-lg peer-checked:bg-primary-50 peer-checked:border-primary-500 hover:border-gray-300 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $level->name }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    @if($level->name === 'Beginner')
                                        New to fitness or returning after a long break
                                    @elseif($level->name === 'Intermediate')
                                        Some experience with regular exercise
                                    @else
                                        Experienced with consistent training
                                    @endif
                                </div>
                            </div>
                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-primary-500 peer-checked:border-primary-500 transition-colors"></div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('experience_level_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Preferred Workout Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">
                What's your preferred workout type?
            </label>
            <div class="grid grid-cols-1 gap-3">
                @foreach($workoutTypes as $type)
                <label class="relative flex cursor-pointer">
                    <input type="radio" name="preferred_workout_type_id" value="{{ $type->id }}" 
                           class="sr-only peer" 
                           {{ old('preferred_workout_type_id', session('onboarding_step2.preferred_workout_type_id')) == $type->id ? 'checked' : '' }}
                           required>
                    <div class="w-full p-4 text-left bg-white border-2 border-gray-200 rounded-lg peer-checked:bg-primary-50 peer-checked:border-primary-500 hover:border-gray-300 transition-colors">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium text-gray-900">{{ $type->name }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    @if($type->name === 'Weight Lifting')
                                        Gym-based workouts with weights and machines
                                    @else
                                        Bodyweight exercises you can do at home
                                    @endif
                                </div>
                            </div>
                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full peer-checked:bg-primary-500 peer-checked:border-primary-500 transition-colors"></div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('preferred_workout_type_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between pt-6">
            <a href="{{ route('onboarding.step1') }}" 
               class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                ← Previous
            </a>

            <button type="submit" 
                    class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition duration-200">
                Next Step →
            </button>
        </div>
    </form>
</div>
@endsection