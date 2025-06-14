<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>
  <div class="bg-white p-6">
    <div class="mx-auto max-w-2xl lg:max-w-7xl">
      <nav aria-label="Breadcrumb" class="mb-4">
        <ol role="list" class="flex items-center space-x-2 text-sm text-gray-500">
          <li><a href="{{ route('produk.index') }}" class="font-medium hover:text-gray-600">Produk</a></li>
          <li><span class="px-2">/</span></li>
          <li><span class="font-medium text-gray-900">{{ $produk->nama }}</span></li>
        </ol>
      </nav>

      <div class="lg:grid lg:grid-cols-2 lg:gap-8">
        <div class="mb-6 lg:mb-0">
          <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="w-full h-auto rounded-lg object-cover">
        </div>

        <div>
          <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">{{ $produk->nama }}</h1>
          <p class="text-2xl tracking-tight text-gray-900 mb-4">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>

          <div class="mb-6">
            <h2 class="sr-only">Deskripsi</h2>
            <p class="text-base text-gray-800">{{ $produk->deskripsi }}</p>
          </div>

          <div class="mt-4">
            <h3 class="text-sm font-medium text-gray-900 mb-2">Spesifikasi</h3>
            <ul role="list" class="list-disc space-y-1 pl-4 text-sm text-gray-600">
              <li>Stok: {{ $produk->stok }}</li>
              <li>Kategori: {{ $produk->kategori ?? 'Umum' }}</li>
            </ul>
          </div>
          <div class="mt-6 flex gap-4">
            {{-- Tombol Kembali ke Daftar Produk --}}
            <a href="{{ route('produk.index') }}"
              class="inline-block px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded">
              ← Kembali
            </a>

            {{-- Tombol ke halaman keranjang atau checkout --}}
            <a href="{{ route('produk.cart') }}"
              class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded">
              Lihat Keranjang
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>