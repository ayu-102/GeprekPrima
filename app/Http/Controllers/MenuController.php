<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {

        $menus = Menu::where('is_active', 1)
            ->where('is_available', 1)
            ->where('stok', '>', 0)
            ->get();

        return view('menu.index', compact('menus'));
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu-user.detail', compact('menu'));
    }

    public function addToCart(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);


        $jumlahDiKeranjang = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;


        if (($jumlahDiKeranjang + 1) > $menu->stok) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi! Sisa stok: ' . $menu->stok);
        }


        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity" => 1,
                "harga" => $menu->harga,
                "foto" => $menu->foto
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('menu.index')->with('success', 'Berhasil ditambah!');
    }
}
