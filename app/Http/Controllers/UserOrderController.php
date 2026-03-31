<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {

        $query = Menu::where('is_active', 1)->where('stok', '>', 0);

        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $menus = $query->get();

        return view('menu-user.index', compact('menus'));
    }

    public function detail($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu-user.detail', compact('menu'));
    }

    public function addToCart(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);
        $qtyYangDiminta = $request->input('quantity', 1);


        $totalQtyDiKeranjang = (isset($cart[$id]) ? $cart[$id]['quantity'] : 0) + $qtyYangDiminta;


        if ($totalQtyDiKeranjang > $menu->stok) {
            return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi. Sisa stok: ' . $menu->stok);
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $totalQtyDiKeranjang;
            if ($request->filled('catatan')) {
                $cart[$id]['catatan'] = $request->catatan;
            }
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "quantity" => $qtyYangDiminta,
                "harga" => $menu->harga,
                "foto" => $menu->foto,
                "catatan" => $request->catatan
            ];
        }

        session()->put('cart', $cart);

        if ($request->action == 'buy_now') {
            return redirect()->route('cart.checkout');
        }

        return redirect()->route('menu-user.index')->with('success', 'Menu ditambahkan!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $id => $details) {
            $total += $details['harga'] * $details['quantity'];
        }

        return view('menu-user.checkout', compact('cart', 'total'));
    }

    public function processOrder(Request $request)
    {
        $cart = session()->get('cart');
        $method = $request->payment_method;

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }


        if ($method == 'qris') {
            $request->validate([
                'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:2048',
                'nama_pengirim'    => 'required|string|max:255',
                'id_transaksi'     => 'nullable|string|max:50',
            ], [
                'bukti_pembayaran.required' => 'Silakan upload bukti transfer QRIS!',
                'nama_pengirim.required'    => 'Harap isi Nama Pemilik Rekening pengirim!'
            ]);
        }

        $pathBukti = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $pathBukti = $request->file('bukti_pembayaran')->store('bukti_bayar', 'public');
        }

        $semuaCatatan = [];
        foreach ($cart as $item) {
            if (!empty($item['catatan'])) {
                $semuaCatatan[] = $item['nama_menu'] . ": " . $item['catatan'];
            }
        }
        $catatanFinal = implode(', ', $semuaCatatan) ?: '-';


        $order = Order::create([
            'nama_pembeli'     => Auth::user()->name,
            'total_harga'      => array_sum(array_map(fn($item) => $item['harga'] * $item['quantity'], $cart)),
            'status'           => 'pending',
            'metode_bayar'     => $method,
            'catatan'          => $catatanFinal,
            'bukti_pembayaran' => $pathBukti,
            'nama_pengirim'    => $request->nama_pengirim,
            'id_transaksi'     => $request->id_transaksi,
            'uang_bayar'       => 0,
            'kembalian'        => 0
        ]);

        foreach ($cart as $id => $details) {
            $menu = Menu::find($id);
            if ($menu) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $id,
                    'jumlah'   => $details['quantity'],
                    'subtotal' => $details['harga'] * $details['quantity'],
                ]);


                $menu->stok -= $details['quantity'];
                $menu->save();
            }
        }

        session()->forget('cart');
        return redirect()->route('order.receipt', $order->id);
    }


    public function receipt($id)
    {
        $order = Order::findOrFail($id);
        return view('menu-user.receipt', compact('order'));
    }
}
