@extends('layout.admin')

@section('title', 'New Signups')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Newly Registered Users</h2>

        <!-- Filter Buttons -->
        <div class="mb-6 flex gap-2">
            @foreach (['day' => 'Today', 'week' => 'This Week', 'month' => 'This Month'] as $key => $label)
                <a href="{{ route('admin.new-signups', ['filter' => $key]) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium 
                          {{ $filter === $key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Signup Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                {{ optional($user->userProfile)->first_name }}
                                {{ optional($user->userProfile)->last_name ?? $user->name }}
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No new users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
