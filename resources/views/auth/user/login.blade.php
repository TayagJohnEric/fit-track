<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

        @if($errors->any())
            <div class="mb-4 text-red-600 text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full mt-1 border border-gray-300 p-2 rounded">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 border border-gray-300 p-2 rounded">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

        <p class="mt-4 text-sm text-center">
            Don't have an account?
            <a href="{{ route('register.form') }}" class="text-blue-500 hover:underline">Register</a>
        </p>
    </div>

</body>
</html>
