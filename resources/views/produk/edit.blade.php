<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <input name="nama" value="{{ old('nama', $produk->nama) }}" class="w-full border p-2 rounded" placeholder="Nama Produk">
                    </div>

                    <div class="mb-4">
                        <textarea name="deskripsi" class="w-full border p-2 rounded" placeholder="Deskripsi">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <input name="harga" type="number" value="{{ old('harga', $produk->harga) }}" class="w-full border p-2 rounded" placeholder="Harga">
                    </div>

                    <div class="mb-4">
                        <input name="stok" type="number" value="{{ old('stok', $produk->stok) }}" class="w-full border p-2 rounded" placeholder="Stok">
                    </div>

                    <div class="mb-4">
                        <input name="gambar" type="file" class="w-full">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-32 mt-2 rounded">
                        @endif
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>