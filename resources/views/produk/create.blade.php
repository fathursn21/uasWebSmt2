
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input name="nama" placeholder="Nama Produk" class="w-full border p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full border p-2 rounded"></textarea>
                    </div>
                    <div class="mb-4">
                        <input name="harga" type="number" placeholder="Harga" class="w-full border p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <input name="stok" type="number" placeholder="Stok" class="w-full border p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <input name="gambar" type="file" class="w-full">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                        Tambah Produk
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
