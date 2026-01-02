<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mentor - KelasKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        
        <div class="w-64 bg-white shadow-lg hidden md:block">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-blue-600">Mentor Area</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('mentor.dashboard') }}" class="flex items-center px-6 py-3 bg-blue-50 text-blue-700 border-r-4 border-blue-600">
                    <i class="fas fa-home w-6"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ url('/mentor/kelas') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                    <i class="fas fa-book w-6"></i>
                    <span class="font-medium">Kelola Kelas</span>
                </a>

                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                    <i class="fas fa-wallet w-6"></i>
                    <span class="font-medium">Pendapatan</span>
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Ringkasan Statistik</h2>
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">Halo, {{ Auth::user()->fullname ?? 'Mentor' }}</span>
                    <form action="#" method="POST"> 
                        @csrf 
                        <button class="text-red-500 hover:text-red-700 text-sm font-semibold">Logout</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Total Kelas</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalKelas }}</h3>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                                <i class="fas fa-chalkboard-teacher text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Total Siswa</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</h3>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full text-green-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-yellow-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Pendapatan</p>
                                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                                <i class="fas fa-wallet text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-purple-500">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Rating</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $avgRating }} <span class="text-sm text-gray-400">/ 5</span></h3>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Transaksi Terakhir</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                                    <th class="px-6 py-3">Siswa</th>
                                    <th class="px-6 py-3">Kelas</th>
                                    <th class="px-6 py-3 text-right">Harga</th>
                                    <th class="px-6 py-3 text-center">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @forelse($recentActivities as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $item->transaksi->user->fullname ?? 'User' }}
                                    </td>
                                    <td class="px-6 py-4">{{ $item->kelas->nama_kelas }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-green-600">
                                        Rp {{ number_format($item->harga_saat_beli, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                        Belum ada data transaksi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

</body>
</html>