@include('layouts.navigation')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-6">Checkout Produk</h2>

    @if ($keranjang->isEmpty())
        <p class="text-gray-600">Keranjang Anda kosong.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($keranjang as $item)
            <div class="border rounded-xl shadow-md p-4">
                <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                     alt="{{ $item->produk->nama }}"
                     class="w-full max-h-48 object-contain rounded-lg mb-3 bg-white">

                <h3 class="text-lg font-semibold">{{ $item->produk->nama }}</h3>
                <p class="text-gray-700 mb-1">Harga: Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</p>

                <div class="flex items-center gap-2 my-2">
                    <form action="{{ route('keranjang.kurang', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-8 h-8 bg-gray-300 rounded hover:bg-gray-400 text-lg font-bold">–</button>
                    </form>

                    <span class="text-lg font-medium">{{ $item->jumlah }}</span>

                    <form action="{{ route('keranjang.tambah', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-8 h-8 bg-gray-300 rounded hover:bg-gray-400 text-lg font-bold">+</button>
                    </form>
                </div>

                <p class="text-sm text-gray-600">Subtotal: Rp{{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        <!-- Total dan Tombol Checkout -->
        <div class="mt-8 border-t pt-4">
            <p class="text-xl font-bold">
                Total: Rp{{ number_format($keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah), 0, ',', '.') }}
            </p>

            <form action="{{ route('checkout.proses') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md shadow">
                    Proses Checkout
                </button>
            </form>
        </div>
    @endif

     
</div>
