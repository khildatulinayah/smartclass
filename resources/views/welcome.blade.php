<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="content=width=device-width, initial-scale=1.0">
    <title>SMARTCLASS - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">SMARTCLASS Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
        </form>
        <div class="mt-4 text-sm text-gray-600">
            <p><strong>Default Accounts:</strong></p>
            <p>Admin: admin@smartclass.com / password</p>
            <p>Bendahara: bendahara@smartclass.com / password</p>
            <p>Sekretaris: sekretaris@smartclass.com / password</p>
            <p>Siswa: siswa1@smartclass.com / password</p>
        </div>
    </div>
</body>
</html>
