<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
	private function cartCheckProduct($array, $key, $val) {
		foreach ($array as $item)
			if (isset($item[$key]) && $item[$key] == $val)
				return true;
		return false;
	}

	private function searchForId($product_id, $array){
		foreach($array as $key => $val){
			if($val['0'] === $product_id)
				return $key;
		}
		return null;
	}

	private function cartCount($array){
		$count = 0;
		foreach($array as $key => $val){
			$count += $val['1'];
		}
		return $count;
	}

    public function index(Request $request)
    {
        $products = Product::paginate(12);

        return view('shop.index', [
            'products' => $products
        ]);
    }

    public function cart(Request $request)
    {
    	$cart_items = $request->session()->get('cart');
    	if (isset($cart_items)) {
    		
    		$idsArray = [];
    		foreach($cart_items as $key => $val){
				$id = $val['0'];
				array_push($idsArray, $id);
			}
			
			$products = Product::whereIn('id', $idsArray)->get();

			return view('shop.cart', [
	            'products' => $products,
	            'cart_items' => $cart_items,
	        ]);
    	}else{
    		return view('shop.cart', [
    			'cart_items' => $cart_items,
    		]);
    	}
    }

    public function addCart(Request $request)
    {
    	// pobranie id produktu
    	$data = $request->all();
    	$product_id = $data['id'];
    	// pobranie sesji koszyka
    	$cart_items = $request->session()->get('cart');
    	// sprawdzenie czy istnieje
    	if (!isset($cart_items)) {
    		$cart_items = [];	
    		$request->session()->put('cart', $cart_items);
    		$cart_items = $request->session()->get('cart');
    	}
    	// zapis produktu do koszyka
    	$cartCheckProduct = $this->cartCheckProduct($cart_items, 0, $product_id);
		if ($cartCheckProduct == false) {
			array_push($cart_items, array($product_id, 1));
			$request->session()->put('cart', $cart_items);
		} else {
			$id = $this->searchForId($product_id, $cart_items);
			$cart_items[$id][1] = $cart_items[$id][1] + 1;
			$request->session()->put('cart', $cart_items);
		}
		// pobranie liczby produktów z koszyka
		$cartCount = $this->cartCount($cart_items);
		// zwrócenie aktualnej liczby produktów
        return response()->json(['cart_count'=>$cartCount]);
    }

    public function deleteCart(Request $request)
    {
    	// usunięcie koszyka
    	$request->session()->forget('cart');
    	// zwrócenie aktualnej liczby produktów
        return response()->json(['cart_count'=>0]);
    }
}