<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user_id = 1;
            $cart = UserCart::where('product_id', $request->product_id)->where('user_id', user_id)->first();
            if ($cart) {
                return response()->json(['status' => true, 'message' => 'This Product is already added in your cart.']);
            }

            $insert = new UserCart;
            $insert->product_id = $request->product_id;
            $insert->user_id = user_id;
            $insert->save();

            return response()->json(['success' => true, 'message' => 'Product added to cart']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function cart_list(Request $request)
    {
        try {
            $userId = 1;

            $cartItems = UserCart::select('id', 'user_id', 'product_id', 'created_at')->with(['get_product' => function ($q) {
                $q->select('id', 'name', 'price', 'images', 'created_at');
            }])->where('user_id', $userId)->get();

            $total_amt = [];
            foreach ($cartItems as $row) {
                $row->get_product->images = explode(',', $row->get_product->images);
                $row->get_product->price = (string) $row->get_product->price;
                $total_amt[] = $row->get_product->price;
            }

            $cart_total_amount = (string) number_format(array_sum($total_amt), 2);

            return response()->json(['status' => true, 'message' => 'Cart Items', 'data' => ['cart_items' => $cartItems, 'cart_total_amount' => $cart_total_amount]]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete_product_from_cart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cart_id' => 'required|exists:user_carts,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $data = UserCart::where('id', $request->cart_id)->delete();

            return response()->json(['status' => true, 'message' => 'Remove product from cart successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
