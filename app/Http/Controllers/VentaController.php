<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('user')->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('ventas.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fecha_venta' => 'required|date',
            'metodo_pago' => 'required|string',
            'productos' => 'required|array',
            'productos.*.product_id' => 'required|exists:products,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'iva' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $venta = new Venta();
            $venta->user_id = $request->input('user_id');
            $venta->fecha_venta = $request->input('fecha_venta');
            $venta->metodo_pago = $request->input('metodo_pago');
            $venta->iva = $request->input('iva');

            $total = 0;
            foreach ($request->input('productos') as $producto) {
                $product = Product::findOrFail($producto['product_id']);
                $subtotal = $product->pro_price * $producto['cantidad'];
                $total += $subtotal;
            }
            $venta->total_venta = $total + ($total * $venta->iva / 100);

            $venta->save();

            foreach ($request->input('productos') as $producto) {
                $product = Product::findOrFail($producto['product_id']);
                $venta->products()->attach($producto['product_id'], [
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $product->pro_price,
                    'subtotal' => $product->pro_price * $producto['cantidad']
                ]);
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta creada con éxito.');
    }

    public function show(Venta $venta)
    {
        $venta->load('user', 'products');
        // dd($venta->toArray()); // Esto mostrará todos los datos de la venta, incluyendo los productos
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $users = User::all();
        $allProducts = Product::all(); // Cambiado de $products a $allProducts
        $venta->load('products');
        return view('ventas.edit', compact('venta', 'users', 'allProducts'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fecha_venta' => 'required|date',
            'metodo_pago' => 'required|string',
            'productos' => 'required|array',
            'productos.*.product_id' => 'required|exists:products,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'iva' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $venta) {
            $venta->user_id = $request->input('user_id');
            $venta->fecha_venta = $request->input('fecha_venta');
            $venta->metodo_pago = $request->input('metodo_pago');
            $venta->iva = $request->input('iva');

            $total = 0;
            $productos = $request->input('productos');

            // Eliminar productos existentes
            $venta->products()->detach();

            foreach ($productos as $producto) {
                $product = Product::findOrFail($producto['product_id']);
                $subtotal = $product->pro_price * $producto['cantidad'];
                $total += $subtotal;

                // Agregar nuevo producto a la venta
                $venta->products()->attach($producto['product_id'], [
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $product->pro_price,
                    'subtotal' => $subtotal
                ]);
            }

            $venta->total_venta = $total + ($total * $venta->iva / 100);
            $venta->save();
        });

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy(Venta $venta)
    {
        $venta->products()->detach();
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $ventas = Venta::with('user')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('firstname', 'like', '%' . $query . '%')
                    ->orWhere('firstlastname', 'like', '%' . $query . '%');
            })
            ->orWhere('metodo_pago', 'like', '%' . $query . '%')
            ->paginate(10);

        return view('ventas.index', compact('ventas'));
    }
}
