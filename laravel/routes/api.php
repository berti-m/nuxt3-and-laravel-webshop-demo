<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/products', function (){
    return Product::where(function($item){
            $item->where('name', 'like', '%'.request('search').'%')->orWhere('description', 'like', '%'.request('search').'%');
        })
        ->latest()->get()->map(function($product){
        return [
            'id' => $product->id,
            'name' => $product->name,
            'picture' => $product->picture,
            'number_available' => $product->number_available,
            'price' => $product->price,
        ];
    });
});

Route::get('/product/{product:id}', function (Product $product){
    return [
            'id' => $product->id,
            'name' => $product->name,
            'picture' => $product->picture,
            'description' => $product->description,
            'number_available' => $product->number_available,
            'price' => $product->price,
        ];
});

Route::post('/order', function (){
    $atr = request()->validate([
        'name' => 'required|string',
        'surname' => 'required|string',
        'email' => 'required|email',
        'address' => 'required|string',
        'town' => 'required|string',
        'postal_code' => 'required|string',
        'country' => 'required|string',
        'additional_data' => 'string|nullable',
        'products' => 'required|string'
    ]);
    $products = json_decode($atr['products'], true);
    foreach ($products as $product){
        if (!is_numeric($product['quantity']) || ($p = Product::where('id', '=', $product['id'])->first()) == null || $product['quantity'] > $p->number_available) {
            if($product['quantity'] > 0){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'additional_data' => [
                        "Some of the items aren't available in desired quantity:",
                        ($p ? $p->name : "?")." -> ".$product['quantity']." / ".($p ? $p->number_available : "?")
                    ]]
                );
            }
        }
    }
    $order = Order::create([
        'name' => $atr['name'],
        'surname' => $atr['surname'],
        'email' => $atr['email'],
        'address' => $atr['address'],
        'town' => $atr['town'],
        'postal_code' => $atr['postal_code'],
        'country' => $atr['country'],
        'additional_data' => $atr['additional_data'],
    ]);
    
    foreach ($products as $product){
        if ($product['quantity'] > 0){
            OrderProducts::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);
            $p = Product::where('id', '=', $product['id'])->first();
            $p->number_available -= $product['quantity'];
            $p->save();
            $order->total += $p->price * $product['quantity'];
        }
    }
    $order->save();
    return ['success' => true];
});

Route::post('/login', function (){
    $atr = request()->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:7'
    ]);
    if (!auth()->attempt($atr)){
        throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Wrong credentials!'
        ]);
    }
    return ['success' => true];
    
});

Route::get('/user', function (Request $request) {
    return ['auth' => $request->user()];
})->middleware(['auth:sanctum']);

Route::middleware(['auth:sanctum'])->post('/logout', function (){
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        return;
});

Route::middleware(['auth:sanctum'])->get('/orders', function (){
        return Order::with('products')->latest()->get();
});
Route::middleware(['auth:sanctum'])->get('/order/{order:id}', function (Order $order){
        return $order->load('products');
});