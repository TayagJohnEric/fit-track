@extends('layout.admin')
@section('title', 'Workout Templates')
@section('content')
<div class="max-w-[90rem] mx-auto">
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4">Workout Templates</h2>

    @if(session('success'))
      <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="flex flex-wrap gap-4 items-center mb-4">
      <form method="GET" action="{{ route('workout_templates.index') }}" class="flex flex-wrap gap-2">
        <input type="text" name="search" placeholder="Search..." value="{{ $search }}"
               class="px-4 py-2 border rounded focus:outline-none">
        <select name="experience_level_id" class="px-4 py-2 border rounded">
          <option value="">All Levels</option>
          @foreach($levels as $id => $name)
            <option value="{{ $id }}" @selected($level == $id)>{{ $name }}</option>
          @endforeach
        </select>
        <select name="workout_type_id" class="px-4 py-2 border rounded">
          <option value="">All Types</option>
          @foreach($types as $id => $name)
            <option value="{{ $id }}" @selected($type == $id)>{{ $name }}</option>
          @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
      </form>
      <a href="{{ route('workout_templates.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-auto">
        Add New
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Level</th>
            <th class="px-4 py-2 border">Type</th>
            <th class="px-4 py-2 border">Duration</th>
            <th class="px-4 py-2 border">Difficulty</th>
            <th class="px-4 py-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($templates as $t)
            <tr>
              <td class="px-4 py-2 border">{{ $t->name }}</td>
              <td class="px-4 py-2 border">{{ $t->experienceLevel->name }}</td>
              <td class="px-4 py-2 border">{{ $t->workoutType->name }}</td>
              <td class="px-4 py-2 border">{{ $t->duration_minutes }} min</td>
              <td class="px-4 py-2 border">{{ $t->difficulty_level }}/5</td>
              <td class="px-4 py-2 border flex gap-2">
                <a href="{{ route('workout_templates.edit', $t->id) }}" class="text-blue-600 hover:underline">Edit</a>
                <form method="POST" action="{{ route('workout_templates.destroy', $t->id) }}">
                  @csrf @method('DELETE')
                  <button onclick="return confirm('Delete?')" class="text-red-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center py-4">No templates found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $templates->withQueryString()->links() }}</div>
  </div>
</div>
@endsection
