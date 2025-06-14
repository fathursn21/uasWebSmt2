<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Keranjang extends Model
{
    protected $fillable = ['user_id', 'produk_id', 'jumlah'];

    public function produk() {
        return $this->belongsTo(Produk::class);
    }
}
