<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'eZin4pp') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">

<!-- Global Header -->
<header class="bg-blue-600 shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-10 rounded bg-white p-1 shadow">
    <span class="text-xl font-bold text-white">EZIN Sekolah</span>
</div>
        

        <!-- Tombol toggle sidebar untuk mobile -->
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-white focus:outline-none">
            <i class="fa fa-bars text-2xl"></i>
        </button>

        <!-- Navigasi untuk desktop -->
        <nav class="hidden md:flex items-center space-x-4 text-sm text-white">
            <span class="text-white/80">
                {{ Auth::user()->name }} ({{ Auth::user()->getRoleNames()->first() }})
            </span>
            <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
          @if(auth()->user()->hasRole('admin'))
    <a href="{{ route('admin.settings.edit') }}" class="text-sm text-white hover:underline">
        Pengaturan
    </a>
@endif
<a href="{{ route('profile.password.edit') }}" class="text-white hover:underline">
    🔒 Ubah Password
</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:underline">Logout</button>
            </form>
        </nav>
    </div>
</header>

<div class="flex h-screen relative">

    <!-- Backdrop (muncul saat sidebar terbuka di mobile) -->
    <div 
        class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-transition
    ></div>

    <!-- Sidebar -->
    <aside 
        class="fixed inset-y-0 left-0 w-64 bg-white shadow-md p-4 space-y-4 transform transition-transform duration-200 ease-in-out z-50
               md:relative md:translate-x-0
               -translate-x-full md:block"
        :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    >
        <div class="font-bold text-lg mb-6">E-Zin App</div>

        @hasrole('siswa')
            <a href="{{ route('siswa.dashboard') }}" class="block text-sm hover:underline">Dashboard</a>
            <a href="{{ route('siswa.izin-masuk.form') }}" class="block text-sm hover:underline">Izin Masuk</a>
            <a href="{{ route('siswa.izin-keluar.form') }}" class="block text-sm hover:underline">Izin Keluar</a>
            <a href="{{ route('siswa.izin-masuk.riwayat') }}" class="block text-sm hover:underline">Riwayat Masuk</a>
            <a href="{{ route('siswa.izin-keluar.riwayat') }}" class="block text-sm hover:underline">Riwayat Keluar</a>
        @endhasrole

        @hasrole('guru')
            <a href="{{ route('guru.dashboard') }}" class="block text-sm hover:underline">Dashboard</a>
            <a href="{{ route('guru.scan.form') }}" class="block text-sm hover:underline">Scan QR Kembali</a>
        @endhasrole

        @hasrole('admin')
            <a href="{{ route('admin.dashboard') }}" class="block text-sm hover:underline">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block text-sm hover:underline">Data User</a>
            <a href="{{ route('admin.izin-masuk') }}" class="block text-sm hover:underline">Izin Masuk</a>
            <a href="{{ route('admin.izin-keluar') }}" class="block text-sm hover:underline">Izin Keluar</a>
        @endhasrole

        @hasrole('workstation')
            <a href="{{ route('workstation.dashboard') }}" class="block text-sm hover:underline">Dashboard</a>
            <a href="{{ route('workstation.scan') }}" class="block text-sm hover:underline">Scan Masuk</a>
            <a href="{{ route('workstation.keluar.scan.form') }}" class="block text-sm hover:underline">Scan Keluar</a>
        @endhasrole

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="text-red-500 text-sm hover:underline">Logout</button>
        </form>
    </aside>
@stack('scripts')

    <!-- Main content -->
    <main class="flex-1 overflow-y-auto px-6 lg:px-12 pt-6 pb-8">
        @yield('content')
    </main>
</div>

</body>
</html>
