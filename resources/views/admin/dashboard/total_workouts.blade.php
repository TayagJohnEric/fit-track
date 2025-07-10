@extends('layout.admin')

@section('title', 'Total Workouts Logged')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Total Workouts Logged</h2>

        <!-- Filter Buttons -->
        <div class="mb-6 flex gap-2">
            @foreach (['day' => 'Today', 'week' => 'This Week', 'month' => 'This Month'] as $key => $label)
                <a href="{{ route('admin.total-workouts', ['filter' => $key]) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium 
                          {{ $filter === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Workouts Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">User</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Workout Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Completed At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($workouts as $index => $workout)
                        <tr>
                            <td class="px-6 py-4">{{ $workouts->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                {{ optional($workout->user->userProfile)->first_name }}
                                {{ optional($workout->user->userProfile)->last_name ?? $workout->user->name }}
                            </td>
                            <td class="px-6 py-4">{{ $workout->template->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $workout->completion_date->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No workouts logged.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $workouts->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
