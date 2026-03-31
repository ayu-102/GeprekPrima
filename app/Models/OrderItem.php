<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'jumlah',
        'subtotal'
    ];

    // Relasi balik ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
