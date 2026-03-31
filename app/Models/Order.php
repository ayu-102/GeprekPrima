<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pembeli',
        'total_harga',
        'metode_bayar',
        'status',
        'catatan',
        'bukti_pembayaran',
        'nama_pengirim',
        'id_transaksi',
        'uang_bayar',
        'kembalian'
    ];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
