<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pesanan Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($transaksi->isEmpty())
                    <p class="text-gray-600">Belum ada pesanan.</p>
                @else
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="px-4 py-2">Tanggal</th>
                                <th class="px-4 py-2">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2 text-blue-600 font-semibold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
