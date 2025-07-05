<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - E-Zin App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex h-screen items-center justify-center">
    <div class="text-center px-8">
        <h1 class="text-4xl font-bold mb-4 text-blue-600">E-Zin Sekolah</h1>
        <p class="mb-6 text-gray-600 text-lg">Aplikasi izin masuk dan keluar digital untuk sekolah.</p>
        
        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600">
            Login
        </a>


    </div>
</div>

</body>
</html>
