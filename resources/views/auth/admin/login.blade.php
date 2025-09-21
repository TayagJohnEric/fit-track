<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex justify-center items-center h-screen">
    <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-8 rounded-lg shadow w-96 ">
        @csrf
        
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-8">Admin Login</h2>

        @error('email')
            <div class="text-red-500 text-sm mb-4 p-3 bg-red-50 rounded border-l-4 border-red-400">{{ $message }}</div>
        @enderror

        <div class="mb-4">
            <input type="email" name="email" placeholder="Email" required 
                   class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:border-orange-400 transition-colors" />
        </div>

        <div class="mb-6">
            <input type="password" name="password" placeholder="Password" required 
                   class="w-full p-3 border border-gray-200 rounded focus:outline-none focus:border-orange-400 transition-colors" />
        </div>

        <button type="submit" class="w-full bg-orange-500 text-white p-3 rounded font-medium hover:bg-orange-600 transition-colors">
            Login
        </button>

        <div class="text-center mt-6">
            <a href="{{ route('admin.register') }}" class="text-sm text-orange-600 hover:text-orange-700">Register as Admin</a>
        </div>
    </form>
</body>
</html>