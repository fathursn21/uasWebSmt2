<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{
  
    public function index()
    {
        $produks = Produk::all(); 
        return view('keranjang.index', compact('produks'));
    }


    public function store(Request $request)
    {
        Keranjang::updateOrCreate(
            ['user_id' => Auth::id(), 'produk_id' => $request->produk_id],
            ['jumlah' => DB::raw('jumlah + 1')]
        );
        return back();
    }


    public function tambah(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$produk->id])) {
            $keranjang[$produk->id]['jumlah'] += $request->jumlah;
        } else {
            $keranjang[$produk->id] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'gambar' => $produk->gambar,
                'jumlah' => $request->jumlah,
            ];
        }

        session()->put('keranjang', $keranjang);

        return redirect()->back();
    }

    public function getSnapToken(Request $request)
    {
        $keranjang = session('keranjang', []);
        $user = Auth::user();

        if (empty($keranjang)) {
            return response()->json(['error' => 'Keranjang kosong.'], 400);
        }

        $total = collect($keranjang)->sum(fn($item) => $item['harga'] * $item['jumlah']);

        $items = [];
        foreach ($keranjang as $produkId => $item) {
            $items[] = [
                'id' => $produkId,
                'price' => $item['harga'],
                'quantity' => $item['jumlah'],
                'name' => Str::limit($item['nama'], 50),
            ];
        }

        Config::$serverKey = "";
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $payload = [
            'transaction_details' => [
                'order_id' => 'TRX-' . time(),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => $items,
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        $result = $request->all(); 
        $keranjang = session('keranjang', []);
        $user = Auth::user();

        if (empty($keranjang)) {
            return response()->json(['error' => 'Keranjang kosong.'], 400);
        }



        $totalHarga = collect($keranjang)->sum(fn($item) => $item['jumlah'] * $item['harga']);

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'tanggal' => now(),
            'total_harga' => $totalHarga,
            'status' => 'selesai',
        ]);

        foreach ($keranjang as $produkId => $item) {
            $produk = Produk::find($produkId);
            if (!$produk || $produk->stok < $item['jumlah']) {
                return response()->json(['error' => "Stok tidak cukup untuk {$item['nama']}."], 400);
            }

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produkId,
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
            ]);

            $produk->stok -= $item['jumlah'];
            $produk->save();
        }

        session()->forget('keranjang');

        return response()->json(['message' => 'Transaksi berhasil']);
    }


    public function kurang(Request $request)
    {
        $produkId = $request->input('produk_id');
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$produkId])) {
            $keranjang[$produkId]['jumlah']--;

            if ($keranjang[$produkId]['jumlah'] <= 0) {
                unset($keranjang[$produkId]); 
            }

            session(['keranjang' => $keranjang]);
        }

        return redirect()->back()->with('success', 'Jumlah produk dikurangi');
    }
}
