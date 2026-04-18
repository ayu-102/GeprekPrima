<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class KasirController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.menu')
            ->whereIn('status', ['Antre', 'Proses'])
            ->latest()
            ->get();


        $menus = Menu::where('is_active', 1)->get();

        return view('dashboard', compact('orders', 'menus'));
    }

    public function menu()
    {

        $menus = Menu::where('is_active', 1)->get();
        return view('menu.index', compact('menus'));
    }

    public function pesanan()
    {

        $orders = Order::whereIn('status', ['pending', 'proses', 'Proses'])
            ->orderBy('created_at', 'desc')->get();
        return view('pesanan.index', compact('orders'));
    }

    public function batalkanPesanan($id)
    {
        $order = \App\Models\Order::with('orderItems')->findOrFail($id);


        if ($order->status == 'dibatalkan') {
            return redirect()->back()->with('error', 'Pesanan ini sudah dibatalkan sebelumnya.');
        }


        foreach ($order->orderItems as $item) {

            $menu = \App\Models\Menu::find($item->menu_id);
            if ($menu) {

                $menu->stok = $menu->stok + $item->jumlah;
                $menu->save();
            }
        }


        $order->status = 'batal';
        $order->save();

        return redirect()->back()->with('success', 'Pesanan dibatalkan dan stok telah dikembalikan otomatis!');
    }


    public function riwayat(Request $request)
    {
        $query = Order::query();


        if ($request->has('search')) {
            $query->where('nama_pembeli', 'like', '%' . $request->search . '%')
                ->orWhere('id', 'like', '%' . $request->search . '%');
        }


        $orders = $query->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat.index', compact('orders'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('menu', 'public');
        }

        Menu::create([
            'nama_menu'    => $request->nama_menu,
            'kategori'     => $request->kategori,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'foto'         => $path,
            'is_available' => $request->stok > 0 ? 1 : 0
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required',
            'kategori'  => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'foto'      => 'nullable|image|max:2048'
        ]);

        $data = [
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
        ];

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'stok'      => $request->stok,
            'harga'     => $request->harga,
            'is_available' => $request->stok > 0 ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Menu diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Menu berhasil dinonaktifkan!');
    }

    public function updateStatus($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->update(['status' => 'Selesai']);

        return redirect()->back()->with('success', 'Pesanan telah diselesaikan!');
    }

    public function selesaikanPesanan(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'selesai',
            'metode_bayar' => $request->metode_bayar,
            'uang_bayar' => $request->uang_bayar,
            'kembalian' => $request->kembalian,
        ]);

        return redirect()->route('pesanan.struk', $id);
    }

    public function printStruk($id)
    {

        $order = \App\Models\Order::with('orderItems.menu')->findOrFail($id);


        return view('pesanan.struk', compact('order'));
    }

    public function showDetail($id)
    {
        $order = \App\Models\Order::with('orderItems.menu')->findOrFail($id);

        return view('riwayat.detail', compact('order'));
    }


    public function keuangan(Request $request)
    {
        $query = Order::where('status', 'selesai');

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        } else {
            $query->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'));
        }

        $totalPemasukan = $query->sum('total_harga');
        $totalTransaksi = $query->count();


        $pembayaran = Order::where('status', 'selesai')
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                return $q->whereDate('created_at', $request->tanggal);
            }, function ($q) {
                return $q->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
            })
            ->select('metode_bayar', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('metode_bayar')
            ->get();


        $labelsMetode = $pembayaran->pluck('metode_bayar')->map(fn($item) => strtoupper($item))->toArray();
        $dataMetode = $pembayaran->pluck('total')->toArray();


        // Logika Menu Terlaris
        $menuTerlaris = \App\Models\OrderItem::select('menu_id', \Illuminate\Support\Facades\DB::raw('SUM(jumlah) as total_terjual'))
            ->whereIn('order_id', (clone $query)->pluck('id'))
            ->groupBy('menu_id')
            ->orderBy('total_terjual', 'desc')
            ->with('menu')
            ->first();

        // Laporan Harian Grafik
        $laporanHarian = \App\Models\Order::where('status', 'selesai')
            ->selectRaw('DATE(created_at) as tanggal, COUNT(id) as jml_transaksi, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('keuangan.index', compact(
            'totalPemasukan',
            'totalTransaksi',
            'labelsMetode',
            'dataMetode',
            'menuTerlaris',
            'laporanHarian'
        ));
    }

    public function pengaturan()
    {

        $user = Auth::user();


        if (!$user) {
            return redirect()->route('login');
        }

        return view('pengaturan.index', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($user ? $user->id : ''),
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
        }

        return redirect()->back()->with('success', 'Profil dan Password berhasil diperbarui!');
    }

    public function fetchPesanan()
    {
        $orders = \App\Models\Order::with('orderItems.menu')
            ->whereIn('status', ['pending', 'proses', 'Proses'])
            ->orderBy('created_at', 'desc')->get();


        return view('pesanan._list', compact('orders'));
    }
}
