@include('layouts.navigation')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-auk1lBT6aHJyKJn1"></script>

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($produks as $produk)
        <div class="group border rounded-xl shadow-md p-4 hover:shadow-lg transition bg-white">
            <img src="{{ asset('storage/' . $produk->gambar) }}"
                alt="{{ $produk->nama }}"
                class="w-full max-h-48 object-contain rounded-lg mb-3 bg-white">

            <h3 class="text-lg font-semibold mb-1">{{ $produk->nama }}</h3>
            <p class="text-gray-700 font-medium mb-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mb-2">Stok: {{ $produk->stok }}</p>

            <div class="flex justify-between gap-2">
                {{-- Tombol Kurangi --}}
                <form action="{{ route('keranjang.kurang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <button type="submit"
                        class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        –
                    </button>
                </form>

                {{-- Tombol Tambah --}}
                @if ($produk->stok > 0)
                <form action="{{ route('keranjang.tambah') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" name="jumlah" value="1">
                    <button type="submit"
                        class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        + Keranjang
                    </button>
                </form>
                @else
                <button disabled
                    class="text-sm bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed">
                    Stok Habis
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Sidebar Keranjang --}}
    <div class="fixed top-16 right-0 w-80 h-[calc(100%-4rem)] bg-gray-100 shadow-lg p-6 overflow-y-auto z-40">
        <h2 class="text-xl font-bold mb-4">Keranjang</h2>

        @php
        $keranjang = session('keranjang', []);
        $total = 0;
        @endphp

        @forelse ($keranjang as $id => $item)
        <div class="mb-4">
            <h3 class="text-md font-semibold">{{ $item['nama'] }}</h3>
            <p class="text-sm text-gray-700">Jumlah: {{ $item['jumlah'] }}</p>
            <p class="text-sm text-gray-700">Subtotal: Rp{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</p>
            @php $total += $item['harga'] * $item['jumlah']; @endphp
        </div>
        @empty
        <p class="text-sm text-gray-500">Keranjang kosong.</p>
        @endforelse

        <hr class="my-4">
        <p class="font-bold text-lg">Total: Rp{{ number_format($total, 0, ',', '.') }}</p>

        @if ($total > 0)
        <button id="pay-button"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition mt-4">
            Checkout
        </button>
        @endif
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function(e) {
            e.preventDefault();

            fetch('/keranjang/token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                fetch('/keranjang/checkout', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify(result)
                                    })
                                    .then(() => window.location.href = "/transaksi")
                            },
                            onPending: function(result) {
                                alert("Pembayaran masih pending");
                            },
                            onError: function(result) {
                                alert("Terjadi kesalahan pembayaran");
                            }
                        });
                    } else {
                        alert("Gagal mendapatkan Snap Token");
                    }
                })
                .catch(error => {
                    console.error("Gagal mendapatkan Snap Token:", error);
                    alert("Gagal mengambil Snap Token");
                });
        });
    </script>
</div>