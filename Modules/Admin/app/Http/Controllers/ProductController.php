<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Product,UserCart};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Product List';
        $data = Product::latest()->get();

        return view('admin::product.index', compact('page_title', 'data'));
    }

    public function create(Request $request)
    {
        $page_title = 'Add Product';
        if($request->submit){
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'images.*' => 'required|image',
            ]);

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

            return redirect('admin/products')->with('success','Product Added Successfully.');
        }
        return view('admin::product.create',compact('page_title'));
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'Edit Product';
        $data = Product::find(base64_decode($id));

        if($request->submit){
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'images.*' => 'image|max:5120',
            ]);

            $data->name = $request->name;
            $data->price = $request->price;
            $image = [];
            if ($request->images) {
                foreach ($request->images as $key => $row) {
                    $img = time().$key.'.'.$row->extension();
                    $row->move(public_path('uploads/product_image/'), $img);
                    $image[] = 'public/uploads/product_image/'.$img;
                }
                $data->images = implode(',', $image);
            }
            $data->save();

            return redirect('admin/products')->with('success','Product Updated Successfully');
        }
        return view('admin::product.edit',compact('page_title','data'));
    }

    public function show(Request $request, $id)
    {
        $page_title = 'Edit Product';
        $data = Product::find(base64_decode($id));

        return view('admin::product.show',compact('page_title','data'));
    }

    public function delete(Request $request, $id)
    {
        $data = Product::find(base64_decode($id));
        UserCart::where('product_id',$data->id)->delete();
        $data->delete();

        return back()->with('success','Product Deleted Successfully.');
    }
}
