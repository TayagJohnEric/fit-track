<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-6 rounded shadow-md w-96">
        @csrf
        <h2 class="text-2xl mb-4 font-bold text-center">Admin Login</h2>
        @error('email')
            <div class="text-red-500 text-sm mb-2">{{ $message }}</div>
        @enderror
        <input type="email" name="email" placeholder="Email" required class="w-full mb-4 p-2 border rounded" />
        <input type="password" name="password" placeholder="Password" required class="w-full mb-4 p-2 border rounded" />
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Login</button>
        <div class="text-center mt-4">
            <a href="{{ route('admin.register') }}" class="text-sm text-blue-600">Register as Admin</a>
        </div>
    </form>
</body>
</html> 
