@include('layouts.navigation')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp
@if ($user && $user->role === 'admin')
{{-- TAMPILAN ADMIN --}}
<div class="max-w-7xl mx-auto px-4 py-6">
    
    <div class="mb-6">
        <a href="{{ route('produk.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition">
            + Tambah Handphone
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($produks as $produk)
        <div class="group border rounded-xl shadow-md p-4 hover:shadow-lg transition bg-white">
            <img src="{{ asset('storage/' . $produk->gambar) }}"
                 alt="{{ $produk->nama }}"
                 class="w-full max-h-48 object-contain rounded-lg mb-3 bg-white">

            <h3 class="text-lg font-semibold mb-1">{{ $produk->nama }}</h3>
            <p class="text-gray-700 font-medium mb-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mb-2">Stok: {{ $produk->stok }}</p>

            <div class="flex justify-between gap-2">
                <a href="{{ route('produk.edit', $produk->id) }}"
                   class="w-[63.16px] h-[28px] text-sm bg-yellow-500 text-white flex items-center justify-center rounded hover:bg-yellow-600 transition">
                    Edit
                </a>

                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus produk ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-500">Belum ada produk yang ditambahkan.</p>
        @endforelse
    </div>
</div>
@endif
