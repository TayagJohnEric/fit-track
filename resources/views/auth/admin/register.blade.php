<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form method="POST" action="{{ route('admin.register') }}" class="bg-white p-6 rounded shadow-md w-96">
        @csrf
        <h2 class="text-2xl mb-4 font-bold text-center">Admin Register</h2>
        <input type="text" name="name" placeholder="Name" required class="w-full mb-4 p-2 border rounded" />
        <input type="email" name="email" placeholder="Email" required class="w-full mb-4 p-2 border rounded" />
        <input type="password" name="password" placeholder="Password" required class="w-full mb-4 p-2 border rounded" />
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="w-full mb-4 p-2 border rounded" />
        <button type="submit" class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">Register</button>
        <div class="text-center mt-4">
            <a href="{{ route('admin.login') }}" class="text-sm text-blue-600">Back to Login</a>
        </div>
    </form>
</body>
</html>
