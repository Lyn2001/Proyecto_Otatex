<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class HomeController extends Controller
{
    //
    public function index(){

        $user = User::where('rol_id',2)->get()->count();

        $product = Product::all()->count();

        $order = Order::all()->count();

        $delivered = Order::where('status','Delivered')->get()->count();

        return view('admin.index', compact('user','product','order','delivered'));
    }

    public function home(){

        $product = Product::all();

        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }
        // //esto tambien es puesto del video 20 dicho por el chat
        // dd($product);

        return view('home.index', compact('product','count'));
    }

    public function login_home(){

        $product = Product::all();

        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }

        return view('home.index', compact('product','count'));
    }

    public function product_details($id){

        $data = Product::find($id);
        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }

        return view('home.product_details', compact('data','count'));
    }

    public function add_cart($id){

        $pro_id = $id;

        $user= Auth::user();

        $user_id = $user->id;

        $data = new Cart;

        $data->user_id = $user_id;

        $data->pro_id = $pro_id;

        $data ->save();

        toastr()->closeButton()->success('Product Added to the Cart Successfully');

        return redirect()->back();
        
    }

    public function mycart(){


        if(Auth::id()){
            $user= Auth::user();
            $userid = $user->id;

            $count = Cart::where('user_id',$userid)->count();

            $cart = Cart::where('user_id',$userid)->get();
        }
        return view('home.mycart', compact('count','cart'));
    }

    public function delete_cart($id){
        $data = Cart::find($id);
        $data->delete();

        toastr()->closeButton()->success('Product Removed from the Cart Successfully');
        return redirect()->back();
    }

    public function confirm_order(Request $request) {
        try {
            $name = $request->name;
            $address = $request->address;
            $phone = $request->phone;
    
            $userid = Auth::user()->id;
            $cart = Cart::where('user_id', $userid)->get();
    
            if ($cart->isEmpty()) {
                toastr()->error('No hay productos en el carrito. Orden fallida.');
                return redirect()->back();
            }
    
            foreach ($cart as $carts) {
                $order = new Order;
    
                $order->name = $name;
                $order->rec_address = $address;
                $order->phone = $phone;
                $order->user_id = $userid;
                $order->pro_id = $carts->pro_id;
    
                $order->save();
            }
    
            // Remover los productos del carrito
            Cart::where('user_id', $userid)->delete();
    
            toastr()->closeButton()->success('Producto ordenado exitosamente');
    
        } catch (\Exception $e) {
            // Manejo de errores
            toastr()->error('Ocurrió un error al procesar la orden: ' . $e->getMessage());
            return redirect()->back();
        }
    
        return redirect()->back();
    }

    public function myorders(){

        $user = Auth::user()->id;

        $count = Cart::where('user_id',$user)->get()->count();

        $order = Order::where('user_id',$user)->get();
        return view('home.order', compact('count','order'));
    }

    protected function logout(Request $request){
        return redirect('/');
    }

    public function shop(){

        $product = Product::all();

        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }
        // //esto tambien es puesto del video 20 dicho por el chat
        // dd($product);

        return view('home.shop', compact('product','count'));
    }

    public function why(){


        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }
        // //esto tambien es puesto del video 20 dicho por el chat
        // dd($product);

        return view('home.why', compact('count'));
    }


    public function testimonial(){


        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }
        // //esto tambien es puesto del video 20 dicho por el chat
        // dd($product);

        return view('home.testimonial', compact('count'));
    }


    public function contact2(){


        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id;
    
            $count = Cart::where('user_id',$userid)->count();
    
        }
        else{   
            $count = '';
        }
        // //esto tambien es puesto del video 20 dicho por el chat
        // dd($product);

        return view('home.contact2', compact('count'));
    }
    
}
            
