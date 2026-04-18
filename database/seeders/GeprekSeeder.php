<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\User;

class GeprekSeeder extends Seeder
{

    public function run(): void

    {

        User::create([
            'name' => 'Owner Geprek',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Budi Beno',
            'email' => 'Budi@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);


        $menus = [
            [
                'nama_menu' => 'Ayam Geprek Sambal Merah',
                'kategori' => 'Makanan',
                'harga' => 15000,
                'stok' => 50,
                'is_available' => 1,
                'is_active' => 1,
                'foto' => 'merah.png'
            ],
            [
                'nama_menu' => 'Es Teh Manis',
                'kategori' => 'Minuman',
                'harga' => 5000,
                'stok' => 100,
                'is_available' => 1,
                'is_active' => 1,
                'foto' => 'es.png'
            ],
        ];

        foreach ($menus as $m) {
            Menu::create($m);
        }
    }
}
