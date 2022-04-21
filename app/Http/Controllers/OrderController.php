<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Orderitem;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cart_items = $request->session()->get('cart');

        return view('order.create', [
            'cart_items' => $cart_items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart_items = $request->session()->get('cart');

        // STEP 1 : validation

        $request->validate([
            '_cart' => 'digits:1',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email:rfc,dns',
        ]);

        $name = $this->checkInput($request->input('name'));
        $surname = $this->checkInput($request->input('surname'));
        $email = $this->checkInput($request->input('email'));

        // STEP 2 : check produsts avalibity

        $orderStstusList = [];
        foreach ($cart_items as $key => $val) {
            
            // id product from cart
            $cart_product_id = $val['0'];
            
            // quantity product from cart
            $cart_product_quantity = $val['1'];
            
            $product = Product::where('id', $cart_product_id)->first();
             
            // quantity product from base
            $base_product_quantity = $product->availability;

            // check if there are enough products
            if ($base_product_quantity >= $cart_product_quantity) {
                array_push($orderStstusList, 1);
            } else {
                array_push($orderStstusList, 0);
            }
        }

        // order status
        $orderStatusTypes = [
            'ACCEPTED' => "accepted",
            'CANCELED' => "canceled",
        ];
        
        if (in_array("0", $orderStstusList)) {
            $orderStatus = $orderStatusTypes['CANCELED'];
        } else {
            $orderStatus = $orderStatusTypes['ACCEPTED'];
        }

        // product status
        if ($orderStatus == 'accepted') {
            
            $warning_level = env('WARNING_LEVEL');

            $productStatusTypes = [
                'LACK' => "lack",
                'LOW' => "low",
                'AVAILABLE' => "available",
            ];

            foreach ($cart_items as $key => $val) {
                
                // id product from cart
                $cart_product_id = $val['0'];
                
                // quantity product from cart
                $cart_product_quantity = $val['1'];
                
                $product = Product::where('id', $cart_product_id)->first();
                 
                // quantity product from base
                $base_product_quantity = $product->availability;

                // check product warning level status
                $calculated_quantity = $base_product_quantity - $cart_product_quantity;

                if ($calculated_quantity < $warning_level) {

                    if ($calculated_quantity <= 0) {
                        $productStatus = $productStatusTypes['LACK'];
                    } else {
                        $productStatus = $productStatusTypes['LOW'];
                    }
                    
                    // update product availability and status
                    Product::where('id', $cart_product_id)->update(['availability' => $calculated_quantity,'status' => $productStatus]);
                    
                } else {

                    // update product availability
                    Product::where('id', $cart_product_id)->update(['availability' => $calculated_quantity]);

                }
            }
          
        }  

        // STEP 3 : create order

        $customer_data = '';
        $form = $request->all();
        $formCount = count($form);
        $i = 1;
        foreach ($form as $key => $value) {
            if ($key == '_token' OR $key == '_cart') {
            } else {
                if ($i == $formCount) {
                    $customer_data .= $value;
                } else {
                    $customer_data .= $value . '|';
                }
            }
            $i++;
        }

        $actualdate = date('Y-m-d H:i:s');

        Order::create([
            'customer_data' => $customer_data,
            'date_order' => $actualdate,
            'status' => $orderStatus,
        ]);

        $actualOrder = Order::latest()->first();
        $id_order = $actualOrder->id;

        // STEP 4 : create order items

        if ($orderStatus == 'accepted') {
            foreach ($cart_items as $key => $val) {

                // id product from cart
                $cart_product_id = $val['0'];

                // quantity product from cart
                $cart_product_quantity = $val['1'];

                Orderitem::create([
                    'id_order' => $id_order,
                    'id_product' => $cart_product_id,
                    'quantity' => $cart_product_quantity,
                ]);

            }
        }

        // STEP 5 : return json

        // reset cart session
        $request->session()->forget('cart');

        return response()->json(['orderStatus'=>$orderStatus, 'succes'=>$actualOrder]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function checkInput($input){$input = trim($input);$input = stripslashes($input);$input = htmlspecialchars($input);$input = str_replace("&quot;","''",$input);return $input;}
}
