<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}

        </h2>
    </x-slot>
    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-screen-xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-center">Daftar Produk</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-8">
                @foreach ($produks as $p)
                <a href="{{ route('produk.show', $p->id) }}" class="hover:underline text-blue-600">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama }}" class="w-full h-48 object-contain bg-white mt-6">

                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-1">
                            
                                {{ $p->nama }}
                            
                        </h3>
                        <p class="text-gray-600 text-sm mb-2">{{ \Illuminate\Support\Str::limit($p->deskripsi, 60) }}</p>
                        <p class="text-blue-600 font-bold text-base mb-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Stok: {{ $p->stok }}</p>
                    </div>
                </div>
                </a>
                @endforeach
            </div>

        </div>
    </div>

    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">Tentang Kami</h3>
                <p class="text-sm text-gray-300">Toko HP terpercaya yang menyediakan berbagai jenis smartphone terbaru dengan harga bersaing dan pelayanan terbaik.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Kategori</h3>
                <ul class="text-sm text-gray-300 space-y-2">
                    <li><a href="#" class="hover:text-white">Android</a></li>
                    <li><a href="#" class="hover:text-white">iOS</a></li>
                    <li><a href="#" class="hover:text-white">Aksesoris</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Bantuan</h3>
                <ul class="text-sm text-gray-300 space-y-2">
                    <li><a href="#" class="hover:text-white">Cara Pembelian</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                    <li><a href="#" class="hover:text-white">Kontak Kami</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Ikuti Kami</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-white"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i> Twitter</a>
                </div>
            </div>
        </div>
        <div class="bg-gray-700 text-center py-4 text-sm text-gray-300">
            &copy; {{ date('Y') }} Toko HP | All rights reserved.
        </div>
    </footer>

</x-app-layout>