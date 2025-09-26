<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Product,UserCart};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function add_product(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'images.*' => 'required|image|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $insert = new Product;
            $insert->name = $request->name;
            $insert->price = $request->price;
            $image = [];
            if ($request->images) {
                foreach ($request->images as $key => $row) {
                    $img = time().$key.'.'.$row->extension();
                    $row->move(public_path('uploads/product_image/'), $img);
                    $image[] = 'public/uploads/product_image/'.$img;
                }
                $insert->images = implode(',', $image);
            }
            $insert->save();

            return response()->json(['status' => true, 'message' => 'Product added successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit_product(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'images.*' => 'image|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $update = Product::find($request->product_id);
            $update->name = $request->name;
            $update->price = $request->price;
            $image = [];
            if ($request->images) {
                foreach ($request->images as $key => $row) {
                    $img = time().$key.'.'.$row->extension();
                    $row->move(public_path('uploads/product_image/'), $img);
                    $image[] = 'public/uploads/product_image/'.$img;
                }
                $update->images = implode(',', $image);
            }
            $update->save();

            return response()->json(['status' => true, 'message' => 'Product updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function view_product(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $data = Product::find($request->product_id);
            $data->images = explode(',', $data->images);

            return response()->json(['status' => true, 'message' => 'View Product Detail.', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function product_list(Request $request)
    {
        try {
            $data = Product::select('id', 'name', 'price', 'images', 'created_at')->paginate(10);

            foreach ($data as $row) {
                $row->images = explode(',', $row->images);
            }

            return response()->json(['status' => true, 'message' => 'Product List', 'data' => ['items' => $data->items(), 'total' => $data->total(), 'lastPage' => $data->lastPage()]]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete_product(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $data = Product::find(base64_decode($id));
            UserCart::where('product_id',$data->id)->delete();
            $data->delete();

            return response()->json(['status' => true, 'message' => 'Product Deleted Successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
