<x-layouts.app title="Unlock Restaurant">
    <div class="py-20 bg-gray-50 min-h-screen flex flex-col items-center">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden ring-1 ring-gray-900/5">
            <div class="bg-gray-900 py-6 px-8 text-center">
                <svg class="mx-auto h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <h2 class="mt-4 text-2xl font-bold text-white">Akses Restoran</h2>
                <p class="text-gray-400 mt-1">{{ $restaurant->name }}</p>
            </div>
            
            <div class="p-8">
                @if ($restaurant->status === 'pending')
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-orange-100 mb-4">
                            <svg class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Menunggu Persetujuan</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Restoran Anda sedang dalam tahap peninjauan oleh admin. Mohon bersabar menunggu hingga proses validasi selesai agar Anda dapat mulai beroperasi.
                        </p>
                    </div>
                @elseif ($restaurant->status === 'locked')
                    <div class="text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 mb-4">
                            <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Akses Diblokir</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Akses ke restoran Anda telah ditahan oleh sistem atau admin. Silakan hubungi layanan bantuan atau admin untuk menyelesaikan masalah ini.
                        </p>
                    </div>
                @else
                    <form action="{{ route('mitra.restaurants.unlock', $restaurant) }}" method="POST">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Masukkan PIN Restoran</label>
                            <input type="password" name="pin" autofocus required 
                                class="mt-2 block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-center text-xl tracking-[0.5em]">
                            @error('pin')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="mt-6 w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Buka Kunci (Unlock)
                        </button>
                    </form>
                @endif

                @if ($restaurant->status === 'unlocked')
                    <div class="mt-6 text-center text-sm">
                        <a href="{{ route('mitra.dashboard') }}" class="font-medium text-gray-500 hover:text-gray-900">
                            &larr; Kembali ke Dashboard
                        </a>
                    </div>
                @else
                    <div class="mt-6 text-center">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="font-medium text-red-500 hover:text-red-700">
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
