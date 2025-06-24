<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full mt-1 border border-gray-300 p-2 rounded">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full mt-1 border border-gray-300 p-2 rounded">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 border border-gray-300 p-2 rounded">
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full mt-1 border border-gray-300 p-2 rounded">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>

        <p class="mt-4 text-sm text-center">
            Already have an account?
            <a href="{{ route('login.form') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
